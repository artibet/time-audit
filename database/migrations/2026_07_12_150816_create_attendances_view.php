<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    DB::statement("DROP VIEW IF EXISTS v_attendances");

    DB::statement("
      CREATE VIEW v_attendances AS
      (
        SELECT
          CONCAT(v_punches.employee_id, '-', v_punches.punch_date_string) AS id,
          v_punches.employee_id employee_id,
          employees.lastname lastname,
          employees.firstname firstname,
          employees.shift_start shift_start,
          employees.shift_end shift_end,
          v_punches.punch_year punch_year,
          v_punches.punch_month punch_month,
          v_punches.punch_day punch_day,
          v_punches.punch_month_name punch_month_name,
          v_punches.punch_date_string punch_date_string,

          -- punch in and out datetimes
          MIN(CASE WHEN direction = 'in' THEN punched_at END) AS punch_in,
          MAX(CASE WHEN direction = 'out' THEN punched_at END) AS punch_out,

          -- total minutes between shift_start and shift_end
          -- these are the minutes he/she has to work
          TIMESTAMPDIFF(
            MINUTE, 
            employees.shift_start, 
            employees.shift_end
          ) AS shift_minutes,

          -- total minutes worked
          -- Total minutes worked (Returns NULL if punch_in or punch_out is missing)
          TIMESTAMPDIFF(
            MINUTE, 
            MIN(CASE WHEN direction = 'in' THEN punched_at END), 
            MAX(CASE WHEN direction = 'out' THEN punched_at END)
          ) AS worked_minutes,

          -- overtime
          -- Τα λεπτά που δούλεψε μετά το shift_end
          GREATEST(
            TIMESTAMPDIFF(
              MINUTE, 
              employees.shift_end, 
              TIME(MAX(CASE WHEN direction = 'out' THEN punched_at END))
            ), 
            0
          ) AS overtime_minutes

        FROM
          v_punches 
          INNER JOIN employees ON employees.id = v_punches.employee_id
        GROUP BY
          v_punches.employee_id,
          employees.lastname,
          employees.firstname,
          employees.shift_start,
          employees.shift_end,
          v_punches.punch_year,
          v_punches.punch_month,
          v_punches.punch_day,
          v_punches.punch_month_name,
          v_punches.punch_date_string
      )  
    ");
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    DB::statement("DROP VIEW IF EXISTS v_attendances");
  }
};
