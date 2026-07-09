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
    Schema::create('upload_files', function (Blueprint $table) {
      $table->id();
      $table->string('descr', 255);
      $table->dateTime('starts_at');
      $table->dateTime('ends_at');
      $table->unsignedBigInteger('file_size');
      $table->unsignedInteger('employees_count');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('upload_files');
  }
};
