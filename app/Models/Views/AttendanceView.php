<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class AttendanceView extends Model
{
  protected $table = 'v_attendances';
  public $timestamps = false;
  protected $guarded = [];
  protected function casts(): array
  {
    return [
      'punch_date' => 'datetime',
      'shift_start' => 'datetime',
      'shift_end' => 'datetime',
      'punch_in' => 'datetime',
      'punch_out' => 'datetime',
      'created_at' => 'datetime',
      'updated_at' => 'datetime',
    ];
  }
}
