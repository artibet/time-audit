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
    DB::statement("DROP VIEW IF EXISTS v_count_punch_days");

    DB::statement("
      CREATE OR REPLACE VIEW v_count_punch_days AS
      WITH daily_punches AS (
        SELECT 
          employee_id,
          DATE(punched_at) AS punch_date,
          COUNT(*) AS punches_count
        FROM punches
        GROUP BY 
          employee_id,
          DATE(punched_at)
      )
      SELECT 
        employee_id AS id,
        employees.am,
        employees.lastname,
        employees.firstname,
        SUM(CASE WHEN punches_count = 1 THEN 1 ELSE 0 END) AS days_with_1_punch,
        SUM(CASE WHEN punches_count = 2 THEN 1 ELSE 0 END) AS days_with_2_punches,
        SUM(CASE WHEN punches_count = 3 THEN 1 ELSE 0 END) AS days_with_3_punches,
        SUM(CASE WHEN punches_count = 4 THEN 1 ELSE 0 END) AS days_with_4_punches,
        SUM(CASE WHEN punches_count > 4 THEN 1 ELSE 0 END) AS days_with_over_4_punches,
        COUNT(*) AS total_worked_days
      FROM 
        daily_punches
        LEFT OUTER JOIN employees ON daily_punches.employee_id = employees.id
      GROUP BY 
        employee_id,
        employees.am,
        employees.lastname,
        employees.firstname
    ");
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    DB::statement("DROP VIEW IF EXISTS v_count_punch_days");
  }
};
