<?php

use App\Http\Controllers\UploadFileController;
use Illuminate\Support\Facades\Route;


Route::prefix('/upload-files')->middleware('auth')->group(function () {
  Route::get('', [UploadFileController::class, 'index'])->name('upload-files.index');
  Route::get('/ssp', [UploadFileController::class, 'ssp'])->name('upload-files.ssp');
  Route::get('/{uploadFile}/ssp-punches', [UploadFileController::class, 'sspPunches'])->name('upload-files.ssp-punches');
  Route::post('/', [UploadFileController::class, 'store'])->name('upload-files.store');
  Route::get('/{uploadFile}', [UploadFileController::class, 'show'])->name('upload-files.show');
  Route::put('/{uploadFile}', [UploadFileController::class, 'update'])->name('upload-files.update');
  Route::delete('/{uploadFile}', [UploadFileController::class, 'destroy'])->name('upload-files.destroy');

  // media
  Route::get('/{uploadFile}/download-media', [UploadFileController::class, 'downloadMedia'])->name('upload-files.download-media');
});
