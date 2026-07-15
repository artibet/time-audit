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
    DB::statement("DROP VIEW IF EXISTS v_monthly_overtimes");

    DB::statement("
      CREATE VIEW v_monthly_overtimes AS
      (
        SELECT 
          attendances.employee_id AS employee_id,
          employees.am AS am,
          employees.lastname AS lastname,
          employees.firstname AS firstname,
          attendances.punch_year AS punch_year,
          attendances.punch_month AS punch_month,
          SUM(attendances.overtime_minutes) AS raw_overtime_minutes,
          LEAST(SUM(attendances.overtime_minutes), 1200) AS capped_overtime_minutes
        FROM 
          attendances
          INNER JOIN employees ON employees.id = attendances.employee_id
        GROUP BY 
          attendances.employee_id,
          employees.am,
          employees.lastname,
          employees.firstname,
          attendances.punch_year,
          attendances.punch_month
      )  
    ");
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    DB::statement("DROP VIEW IF EXISTS v_monthly_overtimes");
  }
};
