<?php

namespace App\Http\Controllers;

use App\Http\Resources\MonthName\Lookup as MonthNameLookupResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReportsController extends Controller
{
  // ---------------------------------------------------------------------------------------
  // Υπερωρίες περιόδου (overtime)
  // ---------------------------------------------------------------------------------------
  public function periodOvertimes(Request $request)
  {
    // available years from attendances
    $availableYears = DB::table('attendances')
      ->distinct()
      ->orderBy('punch_year', 'desc')
      ->pluck('punch_year')
      ->map(function ($year) {
        return [
          'id' => (int) $year,
          'label' => (string) $year
        ];
      })
      ->toArray();

    // months from month_name table
    $months = DB::table('month_names')
      ->orderBy('id', 'asc')
      ->get();

    // Check if the user has actively submitted the form
    $hasSubmitted = $request->has(['year', 'month_from', 'month_to']);
    $reportData = [];

    if ($hasSubmitted) {
      $year = (int) $request->input('year');
      $fromMonth = (int) $request->input('month_from');
      $toMonth = (int) $request->input('month_to');

      // Query the v_monthly_overtimes MySQL view
      $reportData = DB::table('v_monthly_overtimes')
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
        ->orderBy('firstname', 'asc')
        ->get();
    }

    // Inertia response
    return Inertia::render('Reports/PeriodOvertime/PeriodOvertime', [
      'report' => $reportData,
      'years' => $availableYears,
      'months' => MonthNameLookupResource::collection($months),
      'filters' => [
        'year' => $request->input('year') ? (int) $request->input('year') : null,
        'month_from' => $request->input('month_from') ? (int) $request->input('month_from') : null,
        'month_to' => $request->input('month_to') ? (int) $request->input('month_to') : null,
      ]
    ]);
  }
}
