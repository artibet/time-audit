<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\UploadFile;
use App\Services\UploadFileService;
use Exception;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

#[Signature('app:import-punches {--dir=storage/app/imports : The directory to scan for Excel files} {suffix? : Optional suffix to append to the description}')]
#[Description('Import excel files with punches from a local directory')]
class ImportPunches extends Command
{
  /**
   * Execute the console command.
   */
  public function handle()
  {
    // Dynamically increase memory limit to 512MB for this CLI process
    ini_set('memory_limit', '1024M');

    // Get director to insert from
    $directory = $this->option('dir');
    $suffix = $this->argument('suffix');

    // Resolve absolute path if relative path is provided
    if (!File::isDirectory($directory)) {
      // If not, fall back to evaluating it relative to the project root
      $directory = base_path($directory);
    }

    // Check if the dir given is actually a directory and exists
    if (!File::isDirectory($directory)) {
      $this->error("The directory {$directory} does not exist.");
      return Command::FAILURE;
    }

    // Retrieve all excel files (.xlsx, .xls) from the folder
    $files = collect(File::files($directory))
      ->filter(fn($file) => in_array($file->getExtension(), ['xlsx', 'xls']));
    if ($files->isEmpty()) {
      $this->info("No Excel files found in {$directory}.");
      return Command::SUCCESS;
    }
    $this->info("Found {$files->count()} files to import.");

    // Loop through files and import them
    foreach ($files as $file) {
      $filePath = $file->getRealPath();
      $fileName = $file->getFilename();
      $baseName = $file->getFilenameWithoutExtension();
      $descr = $suffix ? "{$baseName} - {$suffix}" : $baseName;
      $this->warn("Processing file: {$baseName}...");

      $processor = new UploadFileService();

      DB::beginTransaction();

      try {

        // 1. process the file
        $data = $processor->process($filePath);

        // 2. Insert or update employees
        $employeesToUpsert = [];
        foreach ($data['rows'] as $row) {
          $employeesToUpsert[$row['am']] = [
            'am'         => $row['am'],
            'lastname'   => $row['lastname'],
            'firstname'  => $row['firstname'],
            'card_no'    => $row['card_no'],
            'created_at' => now(),
            'updated_at' => now(),
          ];
        }

        if (!empty($employeesToUpsert)) {
          Employee::upsert(
            array_values($employeesToUpsert),
            ['am'],
            ['lastname', 'firstname', 'card_no', 'updated_at']
          );
        }

        // Get IDs of employees for the FK map
        $ams = array_keys($employeesToUpsert);
        $employeeMap = Employee::whereIn('am', $ams)->pluck('id', 'am')->toArray();

        // 3. Create the master UploadFile record
        $uploadFile = UploadFile::create([
          'descr' => $descr,
          'starts_at' => $data['starts_at'],
          'ends_at' => $data['ends_at'],
          'employees_count' => $data['employees_count']
        ]);

        // 4. Associate local file with Spatie Media Library
        // preservingOriginal() makes sure we don't delete the file during import 
        // because we handle deleting it in our own try/catch cycle safely
        $media = $uploadFile->addMedia($filePath)
          ->preservingOriginal()
          ->toMediaCollection('file');

        $uploadFile->update(['file_size' => $media->size]);

        // 5. Bulk insert rows in chunks
        if (!empty($data['rows'])) {
          $punchesToInsert = [];
          foreach ($data['rows'] as $row) {
            $punchesToInsert[] = [
              'upload_file_id' => $uploadFile->id,
              'employee_id'    => $employeeMap[$row['am']],
              'direction'      => $row['direction'],
              'clock_code'     => $row['clock_code'],
              'am'             => $row['am'],
              'lastname'       => $row['lastname'],
              'firstname'      => $row['firstname'],
              'card_no'        => $row['card_no'],
              'shift_string'   => $row['shift_string'],
              'shift_start'    => $row['shift_start'],
              'shift_end'      => $row['shift_end'],
              'punched_at'     => $row['punched_at'],
            ];
          }

          foreach (array_chunk($punchesToInsert, 500) as $chunk) {
            DB::table('punches')->insert($chunk);
          }
        }

        // 6. Update employees stats
        $employeeIds = array_values($employeeMap);
        if (!empty($employeeIds)) {
          DB::table('employees as e')
            ->whereIn('e.id', $employeeIds)
            ->update([
              'last_in' => DB::raw("(
                  SELECT MAX(punched_at) 
                  FROM punches 
                  WHERE employee_id = e.id AND direction = 'in'
              )"),
              'last_out' => DB::raw("(
                  SELECT MAX(punched_at) 
                  FROM punches 
                  WHERE employee_id = e.id AND direction = 'out'
              )")
            ]);
        }

        // 7. Commit and delete original file
        DB::commit();
        File::delete($filePath);
        $this->info("Successfully imported {$fileName} and removed from directory.");
      } catch (Exception $e) {
        DB::rollBack();
        if (isset($media)) {
          $media->delete();
        }
        $this->error("Failed importing {$fileName}: " . $e->getMessage());
      }
    }
    $this->info('Import process completed.');
    return Command::SUCCESS;
  }
}
