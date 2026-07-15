<?php

namespace App\Services;

use Carbon\Carbon;

class AttendanceService
{
  /**
   * Process bulk punches and group them into attendance records.
   *
   * @param array $punches
   * @return array
   */
  public function process(array $punches): array
  {
    $groupedPunches = [];
    $attendanceRows = [];

    // Step 1: Group punches by employee_id and date
    foreach ($punches as $punch) {
      $employeeId = $punch['employee_id'];
      $punchDate = Carbon::parse($punch['punched_at'])->format('Y-m-d');

      $groupedPunches[$employeeId][$punchDate][] = $punch;
    }

    // Step 2: Iterate through groups to build attendance rows
    foreach ($groupedPunches as $employeeId => $dates) {
      foreach ($dates as $date => $dayPunches) {

        // Filter punches by direction
        $inPunches = array_filter($dayPunches, function ($p) {
          return strtolower($p['direction']) === 'in';
        });

        $outPunches = array_filter($dayPunches, function ($p) {
          return strtolower($p['direction']) === 'out';
        });

        // Determine punch_in (earliest 'in' punch)
        $punchIn = null;
        if (!empty($inPunches)) {
          usort($inPunches, function ($a, $b) {
            return strtotime($a['punched_at']) <=> strtotime($b['punched_at']);
          });
          $punchIn = reset($inPunches)['punched_at']; // First element
        }

        // Determine punch_out (latest 'out' punch)
        $punchOut = null;
        if (!empty($outPunches)) {
          usort($outPunches, function ($a, $b) {
            return strtotime($a['punched_at']) <=> strtotime($b['punched_at']);
          });
          $punchOut = end($outPunches)['punched_at']; // Last element
        }

        // Fallback: If one is missing, you might want to handle it according to company policy
        // For now, if either is missing, we use the available one or leave it null
        // $effectivePunchIn = $punchIn ?? $punchOut;
        // $effectivePunchOut = $punchOut ?? $punchIn;

        // if (!$effectivePunchIn && !$effectivePunchOut) {
        //   continue; // Skip if there are no valid in/out punches
        // }

        $carbonDate = Carbon::parse($date);
        $now = Carbon::now();

        // Step 3: Calculate durations based on found times
        $workedMinutes = 0;
        if ($punchIn && $punchOut) {
          $workedMinutes = Carbon::parse($punchIn)->diffInMinutes(Carbon::parse($punchOut));
        }

        // Extract shift details using the first available punch of the day
        $referencePunch = $dayPunches[0];
        $shiftMinutes = 0;

        if (!empty($referencePunch['shift_start']) && !empty($referencePunch['shift_end'])) {
          $shiftMinutes = Carbon::parse($referencePunch['shift_start'])->diffInMinutes(Carbon::parse($referencePunch['shift_end']));
        }

        $workBalance = $workedMinutes - $shiftMinutes;
        $overtimeMinutes = $workBalance > 0 ? $workBalance : 0;

        // Step 4: Map to attendance table structure
        $attendanceRows[] = [
          'employee_id'          => $employeeId,
          'shift_start'          => $referencePunch['shift_start'] ?? null,
          'shift_end'            => $referencePunch['shift_end'] ?? null,
          'shift_string'         => $referencePunch['shift_string'] ?? null,
          'punch_date'           => $date,
          'punch_in'             => $punchIn,
          'punch_out'            => $punchOut,
          'punch_year'           => $carbonDate->year,
          'punch_month'          => $carbonDate->month,
          'punch_day'            => $carbonDate->day,
          'shift_minutes'        => $shiftMinutes,
          'worked_minutes'       => $workedMinutes,
          'work_balance_minutes' => $workBalance,
          'overtime_minutes'     => $overtimeMinutes,
          'created_at'           => $now,
          'updated_at'           => $now,
        ];
      }
    }

    return $attendanceRows;
  }
}
