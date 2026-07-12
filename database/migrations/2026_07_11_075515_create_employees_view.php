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
    DB::statement("DROP VIEW IF EXISTS v_employees");

    DB::statement("
      CREATE VIEW v_employees AS
      (
        SELECT
          id,
          lastname,
          firstname,
          am,
          card_no,
          shift_start,
          shift_end,
          last_in,
          last_out,
          created_at,
          updated_at
        FROM
          employees
      )    
    ");
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    DB::statement("DROP VIEW IF EXISTS v_employees");
  }
};
