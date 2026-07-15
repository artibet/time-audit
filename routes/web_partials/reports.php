<?php

use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

Route::prefix('/reports')->middleware('auth')->group(function () {
  Route::get('/period-overtimes', [ReportsController::class, 'periodOvertimes'])->name('reports.period-overtimes');
});
