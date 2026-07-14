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
        SELECT
          id,
          employee_id,
          lastname,
          firstname,
          punch_year,
          punch_month,
          punch_day,
          punch_month_name,
          punch_date_string,
          punch_in,
          punch_out,
          shift_string,
          shift_start,
          shift_end,
          shift_minutes,
          worked_minutes,
          worked_minutes - shift_minutes AS work_balance_minutes,
          GREATEST(worked_minutes - shift_minutes, 0) AS overtime_minutes
        FROM (
          SELECT
            CONCAT(v_punches.employee_id, '-', v_punches.punch_date_string) AS id,
            v_punches.employee_id employee_id,
            employees.lastname lastname,
            employees.firstname firstname,
            v_punches.punch_year punch_year,
            v_punches.punch_month punch_month,
            v_punches.punch_day punch_day,
            v_punches.punch_month_name punch_month_name,
            v_punches.punch_date_string punch_date_string,

            -- punch in and out datetimes
            MIN(CASE WHEN direction = 'in' THEN punched_at END) AS punch_in,
            MAX(CASE WHEN direction = 'out' THEN punched_at END) AS punch_out,

            -- shift as strign, start and end as times
            MIN(shift_string) AS shift_string,
            MIN(shift_start) AS shift_start,
            MAX(shift_end) AS shift_end,

            -- total minutes between shift_start and shift_end
            -- these are the minutes he/she has to work
            GREATEST(
              FLOOR(  
                (
                  TIME_TO_SEC(TIME(CONVERT_TZ(MAX(CASE WHEN direction = 'out' THEN shift_end END), 'UTC', 'Europe/Athens'))) 
                  - 
                  TIME_TO_SEC(TIME(CONVERT_TZ(MIN(CASE WHEN direction = 'in' THEN shift_start END), 'UTC', 'Europe/Athens'))) 
                ) / 60
              ) ,
              0
            ) AS shift_minutes,

            -- Total minutes worked (Returns NULL if punch_in or punch_out is missing)
            TIMESTAMPDIFF(
              MINUTE, 
              MIN(CASE WHEN direction = 'in' THEN punched_at END), 
              MAX(CASE WHEN direction = 'out' THEN punched_at END)
            ) AS worked_minutes
          FROM
            v_punches 
            INNER JOIN employees ON employees.id = v_punches.employee_id
          GROUP BY
            v_punches.employee_id,
            employees.lastname,
            employees.firstname,
            v_punches.punch_year,
            v_punches.punch_month,
            v_punches.punch_day,
            v_punches.punch_month_name,
            v_punches.punch_date_string
        ) AS inner_table   
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
