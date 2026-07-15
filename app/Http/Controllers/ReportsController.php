<?php

namespace App\Http\Controllers;

use App\Exports\Reports\PeriodOvertimesExport;
use App\Http\Resources\MonthName\Lookup as MonthNameLookupResource;
use App\Services\PeriodOvertimeService;
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
      $overtimeService = new PeriodOvertimeService();
      $reportData = $overtimeService->query($year, $fromMonth, $toMonth)->get();
    }

    // Inertia response
    return Inertia::render('Reports/PeriodOvertimes/PeriodOvertimes', [
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

  // ---------------------------------------------------------------------------------------
  // Period overtimes export
  // ---------------------------------------------------------------------------------------
  public function periodOvertimesExport(Request $request)
  {
    $overtimeService = new PeriodOvertimeService();
    $year = (int) $request->input('year');
    $fromMonth = (int) $request->input('month_from');
    $toMonth = (int) $request->input('month_to');
    $data = $overtimeService->query($year, $fromMonth, $toMonth)->get();
    $export = new PeriodOvertimesExport($data);
    return $export->download();
  }
}
