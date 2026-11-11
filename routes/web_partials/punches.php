<?php

use App\Http\Controllers\PunchController;
use Illuminate\Support\Facades\Route;


Route::prefix('/punches')->middleware('auth')->group(function () {
  Route::get('/count-punch-days', [PunchController::class, 'countPunchDays'])->name('punches.count-punch-days');
  Route::get('/count-punch-days/ssp', [PunchController::class, 'sspCountPunchDays'])->name('punches.count-punch-days-ssp');
});
