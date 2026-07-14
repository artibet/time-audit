<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\UploadFile;
use App\Paginators\UploadFilePaginator;
use App\Paginators\UploadFilePunchPaginator;
use App\Services\UploadFileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use App\Http\Resources\UploadFile\Show as UploadFileShowResource;
use Carbon\Carbon;

class UploadFileController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    Gate::authorize('viewAny', UploadFile::class);

    return Inertia::render('UploadFiles/Index/Index', [
      'policy' => [
        'create' => Gate::allows('create', UploadFile::class)
      ],
      'url' => [
        'store' => route('upload-files.store'),
        'ssp' => route('upload-files.ssp')
      ]
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    Gate::authorize('create', UploadFile::class);

    $processor = new UploadFileService();

    // Validate 
    $request->validate([
      'descr' => 'required',
      'file' => 'required|file'
    ]);

    // Process the file
    try {
      $data = $processor->process($request->file->getPathname());
    } catch (Exception $e) {
      return back()->with('error', $e->getMessage());
    }

    // Start database
    DB::beginTransaction();

    // Insert
    try {

      // Εισαγωγή ή ενημέρωση εργαζομένων
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
          ['am'], // Μοναδικό κλειδί
          ['lastname', 'firstname', 'card_no', 'updated_at'] // Ανανέωση στοιχείων αν υπάρχουν
        );
      }

      // Fetch των IDs των εργαζομένων για να κάνουμε το Foreign Key mapping
      $ams = array_keys($employeesToUpsert);
      $employeeMap = Employee::whereIn('am', $ams)->pluck('id', 'am')->toArray();

      // Create the master recored
      $uploadFile = UploadFile::create([
        'descr' => $request->descr,
        'starts_at' => $data['starts_at'],
        'ends_at' => $data['ends_at'],
        'employees_count' => $data['employees_count']
      ]);

      // Upload the file and set the file_size
      $media = $uploadFile->addMediaFromRequest('file')->toMediaCollection('file');
      $uploadFile->update(['file_size' => $media->size]);

      // Εισαγωγή των γραμμών στον πίνακα upload_file_rows
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

        // Bulk insert in chunks of 500 to keep memory footprint safe and performant
        foreach (array_chunk($punchesToInsert, 500) as $chunk) {
          DB::table('punches')->insert($chunk);
        }
      }

      // Update the last_in and last_out columns into employees
      $employeeIds = array_values($employeeMap);
      if (!empty($employeeIds)) {
        // Perform a bulk update using a subquery for peak performance
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

      // Commit and return to show page
      DB::commit();
      return redirect()
        ->route('upload-files.show', $uploadFile->id)
        ->with('success', 'Το αρχείο κινήσεων εισήχθη με επιτυχία!');
    } catch (Exception $e) {
      DB::rollBack();
      if (isset($media)) {
        $media->delete();
      }
      return back()->with('error', 'Σφάλμα κατά την αποθήκευση: ' . $e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(UploadFile $uploadFile)
  {
    Gate::authorize('view', $uploadFile);

    // breadcrumb
    $breadcrumbs = [
      ['label' => 'Αρχεία Κινήσεων', 'url' => route('upload-files.index')],
      ['label' => $uploadFile->descr, 'url' => null],
    ];

    return Inertia::render('UploadFiles/Show/Show', [
      'upload_file' => new UploadFileShowResource($uploadFile),
      'breadcrumbs' => $breadcrumbs
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(UploadFile $uploadFile)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, UploadFile $uploadFile)
  {
    Gate::authorize('update', $uploadFile);

    // Get posted data
    $field = $request->field;
    $value = $request->value;

    // Upload, save and return back
    $uploadFile->$field = $value;
    $uploadFile->save();
    return back();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(UploadFile $uploadFile)
  {
    Gate::authorize('delete', $uploadFile);
    $uploadFile->delete();
    return redirect()->route('upload-files.index')->with('success', "Το αρχείο κινήσεων '{$uploadFile->descr}' διαγράφηκε με επιτυχία!");
  }

  // ---------------------------------------------------------------------------------------
  // Server side pagination table data 
  // ---------------------------------------------------------------------------------------
  public function ssp(Request $request)
  {
    Gate::authorize('viewAny', UploadFile::class);
    return (new UploadFilePaginator($request))->response();
  }

  // ---------------------------------------------------------------------------------------
  // Server side pagination for employee panches
  // ---------------------------------------------------------------------------------------
  public function sspPunches(Request $request, UploadFile $uploadFile)
  {
    Gate::authorize('viewAny', UploadFile::class);
    return (new UploadFilePunchPaginator($request, $uploadFile->id))->response();
  }

  // ---------------------------------------------------------------------------------------
  // Download media file
  // ---------------------------------------------------------------------------------------
  public function downloadMedia(UploadFile $uploadFile)
  {
    Gate::authorize('view', $uploadFile);

    $media = $uploadFile->getFirstMedia('file');

    return response()->download($media->getPath());
  }
}
