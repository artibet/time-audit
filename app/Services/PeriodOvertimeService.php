<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class PeriodOvertimeService
{
  public function query(int $year, int $fromMonth, int $toMonth)
  {
    $dbQuery = DB::table('v_monthly_overtimes')
      ->select([
        'employee_id',
        'am',
        'lastname',
        'firstname',
        DB::raw('SUM(raw_overtime_minutes) as total_raw_minutes'),
        DB::raw('SUM(capped_overtime_minutes) as total_capped_minutes'),
        DB::raw('ROUND(SUM(raw_overtime_minutes) / 60.0, 2) as total_raw_hours'),
        DB::raw('ROUND(SUM(capped_overtime_minutes) / 60.0, 2) as total_capped_hours'),
      ])
      ->where('punch_year', $year)
      ->whereBetween('punch_month', [$fromMonth, $toMonth])
      ->groupBy('employee_id', 'am', 'lastname', 'firstname')
      ->orderBy('lastname', 'asc')
      ->orderBy('firstname', 'asc');

    return $dbQuery;
  }
}
