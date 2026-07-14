<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class PunchView extends Model
{
  protected $table = 'v_punches';
  public $timestamps = false;
  protected $guarded = [];
  protected function casts(): array
  {
    return [
      'shift_start' => 'datetime',
      'shift_end' => 'datetime',
      'punched_at' => 'datetime',
    ];
  }
}
