<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class UploadFile extends Model implements HasMedia
{
  use InteractsWithMedia;

  protected $table = 'upload_files';
  public $timestamps = true;
  protected $guarded = [];
  protected function casts(): array
  {
    return [
      'starts_at' => 'datetime',
      'ends_at' => 'datetime',
    ];
  }

  // ---------------------------------------------------------------------------------------
  // Register media collection
  // ---------------------------------------------------------------------------------------
  public function registerMediaCollections(): void
  {
    $this->addMediaCollection('file')
      ->useDisk('media_private')
      ->singleFile();
  }

  // ---------------------------------------------------------------------------------------
  // Relations
  // ---------------------------------------------------------------------------------------

  // punches
  public function punches()
  {
    return $this->hasMany(Punch::class, 'upload_file_id', 'id');
  }

  // ---------------------------------------------------------------------------------------
  // Register deleting event to cascade delete attendances
  // ---------------------------------------------------------------------------------------
  protected static function booted(): void
  {
    static::deleting(function (UploadFile $uploadFile) {
      // 1. Find all employee/date pairings related to the punches about to be deleted
      $punchPairings = DB::table('punches')
        ->where('upload_file_id', $uploadFile->id)
        ->select('employee_id', DB::raw('DATE(punched_at) as punch_date'))
        ->groupBy('employee_id', 'punch_date')
        ->get();

      if ($punchPairings->isNotEmpty()) {
        // 2. Wrap deletion in a transaction to be safe
        DB::transaction(function () use ($punchPairings, $uploadFile) {

          // Option A: Delete the attendance record entirely for those employee-dates
          foreach ($punchPairings as $pairing) {
            DB::table('attendances')
              ->where('employee_id', $pairing->employee_id)
              ->where('punch_date', $pairing->punch_date)
              ->delete();
          }

          // Option B: If you prefer to recalculate the day instead of deleting it 
          // (in case there are other files providing punches for the same day),
          // you would delete the raw punches, and then trigger your AttendanceService 
          // to recalculate attendance based on the REMAINING punches for those dates.
        });
      }
    });
  }
}
