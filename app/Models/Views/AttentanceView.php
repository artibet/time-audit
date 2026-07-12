<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class AttentanceView extends Model
{
  protected $table = 'v_attendances';
  public $timestamps = false;
  protected $guarded = [];
  protected function casts(): array
  {
    return [
      'shift_start' => 'datetime',
      'shift_end' => 'datetime',
      'punch_in' => 'datetime',
      'punch_out' => 'datetime'
    ];
  }
}
