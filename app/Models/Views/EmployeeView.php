<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class EmployeeView extends Model
{
  protected $table = 'v_employees';
  public $timestamps = false;
  protected $guarded = [];
  protected function casts(): array
  {
    return [
      'shift_start' => 'datetime',
      'shift_end' => 'datetime',
      'last_in' => 'datetime',
      'last_out' => 'datetime',
      'created_at' => 'datetime',
      'updated_at' => 'datetime',
    ];
  }
}
