<?php

use App\Http\Controllers\FortifyController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [FortifyController::class, 'login'])->name('login');
Route::get('/forgot-password', [FortifyController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/reset-password', [FortifyController::class, 'resetPassword'])->name('password.reset');
