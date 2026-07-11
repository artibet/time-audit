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
      'punched_at' => 'datetime',
    ];
  }
}
