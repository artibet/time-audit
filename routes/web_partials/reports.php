<?php

use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

Route::prefix('/reports')->middleware('auth')->group(function () {
  Route::get('/overtime', [ReportsController::class, 'overtime'])->name('reports.overtime');
});
