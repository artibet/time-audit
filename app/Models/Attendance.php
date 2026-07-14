<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
  protected $table = 'attendances';
  public $timestamps = true;
  protected $guarded = [];
  protected function casts(): array
  {
    return [
      'shift_start' => 'datetime',
      'shift_end' => 'datetime',
      'punch_date' => 'datetime',
      'punch_id' => 'datetime',
      'punch_out' => 'datetime',
    ];
  }

  // ---------------------------------------------------------------------------------------
  // Relations
  // ---------------------------------------------------------------------------------------

  // employee
  public function employee()
  {
    return $this->belongsTo(Employee::class, 'employee_id', 'id');
  }
}
