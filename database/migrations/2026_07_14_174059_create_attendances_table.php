<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('attendances', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('employee_id');
      $table->time('shift_start');
      $table->time('shift_end');
      $table->string('shift_string');
      $table->date('punch_date');
      $table->dateTime('punch_in')->nullable();
      $table->dateTime('punch_out')->nullable();
      $table->integer('punch_year');
      $table->integer('punch_month');
      $table->integer('punch_day');
      $table->integer('shift_minutes')->default(0);
      $table->integer('worked_minutes')->default(0);
      $table->integer('work_balance_minutes')->default(0);
      $table->integer('overtime_minutes')->default(0);
      $table->timestamps();

      $table->unique(['employee_id', 'punch_date']);
    });

    // Foreign keys
    Schema::table('attendances', function (Blueprint $table) {
      $table->foreign('employee_id')->references('id')->on('employees');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('attendances');
  }
};
