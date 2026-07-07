<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('/users')->middleware('auth')->group(function () {
  Route::get('', [UserController::class, 'index'])->name('users.index');
  Route::get('/ssp', [UserController::class, 'ssp'])->name('users.ssp');
  Route::post('/', [UserController::class, 'store'])->name('users.store');
  Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
  Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
  Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
  Route::post('/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
});
