<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    DB::statement("DROP VIEW IF EXISTS v_punches");

    DB::statement("
      CREATE VIEW v_punches AS
      (
        SELECT
          punches.id id,
          punches.upload_file_id upload_file_id,
          punches.employee_id employee_id,
          punches.direction direction,
          punches.clock_code clock_code,
          punches.am am,
          punches.lastname lastname,
          punches.firstname firstname,
          punches.card_no card_no,
          punches.shift_string shift_string,
          punches.shift_start shift_start,
          punches.shift_end shift_end,
          punches.punched_at punched_at,
          YEAR(CONVERT_TZ(punches.punched_at, 'UTC', 'Europe/Athens')) AS punch_year,
          MONTH(CONVERT_TZ(punches.punched_at, 'UTC', 'Europe/Athens')) AS punch_month,
          DAY(CONVERT_TZ(punches.punched_at, 'UTC', 'Europe/Athens')) AS punch_day,
          HOUR(CONVERT_TZ(punches.punched_at, 'UTC', 'Europe/Athens')) AS punch_hour,
          MINUTE(CONVERT_TZ(punches.punched_at, 'UTC', 'Europe/Athens')) AS punch_minute,
          SECOND(CONVERT_TZ(punches.punched_at, 'UTC', 'Europe/Athens')) AS punch_second,
          DATE_FORMAT(CONVERT_TZ(punches.punched_at, 'UTC', 'Europe/Athens'), '%d-%m-%Y') AS punch_date_string,
          DATE_FORMAT(CONVERT_TZ(punches.punched_at, 'UTC', 'Europe/Athens'), '%H:%i:%s') AS punch_time_string,
          CASE MONTH(CONVERT_TZ(punches.punched_at, 'UTC', 'Europe/Athens'))
            WHEN 1 THEN 'Ιανουάριος'
            WHEN 2 THEN 'Φεβρουάριος'
            WHEN 3 THEN 'Μάρτιος'
            WHEN 4 THEN 'Απρίλιος'
            WHEN 5 THEN 'Μάιος'
            WHEN 6 THEN 'Ιούνιος'
            WHEN 7 THEN 'Ιούλιος'
            WHEN 8 THEN 'Αύγουστος'
            WHEN 9 THEN 'Σεπτέμβριος'
            WHEN 10 THEN 'Οκτώβριος'
            WHEN 11 THEN 'Νοέμβριος'
            WHEN 12 THEN 'Δεκέμβριος'
          END AS punch_month_name,
          CASE
            WHEN punches.direction = 'in' THEN 'Είσοδος'
            WHEN punches.direction = 'out' THEN 'Έξοδος'
            ELSE 'Μη έγκυρη τιμή κατεύθυνσης'
          END AS direction_label
        FROM
          punches
      )   
    ");
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    DB::statement("DROP VIEW IF EXISTS v_punches");
  }
};
