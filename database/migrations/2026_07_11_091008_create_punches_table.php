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
    Schema::create('punches', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('upload_file_id');
      $table->unsignedBigInteger('employee_id');
      $table->string('direction', 10);
      $table->string('clock_code', 255);
      $table->string('am', 255);
      $table->string('lastname', 255);
      $table->string('firstname', 255);
      $table->string('card_no', 255);
      $table->string('shift_string', 255);
      $table->time('shift_start');
      $table->time('shift_end');
      $table->dateTime('punched_at');
    });

    // Foreign keys
    Schema::table('punches', function (Blueprint $table) {
      $table->foreign('upload_file_id')->references('id')->on('upload_files')->onDelete('cascade');
      $table->foreign('employee_id')->references('id')->on('employees');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('punches');
  }
};
