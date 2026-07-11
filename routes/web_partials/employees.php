<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;


Route::prefix('/employees')->middleware('auth')->group(function () {
  Route::get('', [EmployeeController::class, 'index'])->name('employees.index');
  Route::get('/ssp', [EmployeeController::class, 'ssp'])->name('employees.ssp');
  Route::post('/', [EmployeeController::class, 'store'])->name('employees.store');
  Route::get('/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
  Route::put('/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
  Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});
