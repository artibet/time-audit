<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class CountPunchDaysView extends Model
{
  protected $table = 'v_count_punch_days';
  public $timestamps = false;
  protected $guarded = [];
  protected function casts(): array
  {
    return [
      'days_with_1_punch' => 'integer',
      'days_with_2_punches' => 'integer',
      'days_with_3_punches' => 'integer',
      'days_with_4_punches' => 'integer',
      'days_with_over_4_punches' => 'integer',
    ];
  }
}
