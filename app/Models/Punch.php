<?php

namespace App\Models;

use App\Enums\PunchDirectionEnum;
use Illuminate\Database\Eloquent\Model;

class Punch extends Model
{
  protected $table = 'punches';
  public $timestamps = false;
  protected $guarded = [];
  protected function casts(): array
  {
    return [
      'shift_start' => 'datetime',
      'shift_end' => 'datetime',
      'punched_at' => 'datetime',
      'direction' => PunchDirectionEnum::class,
    ];
  }

  // ---------------------------------------------------------------------------------------
  // Relations
  // ---------------------------------------------------------------------------------------

  // upload_files
  public function uploadFile()
  {
    return $this->belongsTo(UploadFile::class, 'upload_file_id', 'id');
  }

  // employees
  public function employee()
  {
    return $this->belongsTo(Employee::class, 'employee_id', 'id');
  }
}
