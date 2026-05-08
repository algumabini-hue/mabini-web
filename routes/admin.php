<?php

use App\Http\Controllers\AdminOfficialController;
use App\Http\Controllers\AdminOrdinanceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Admin-specific routes for managing ordinances, officials, and other
| administrative features. These routes are typically protected by
| authentication middleware.
|
*/

Route::middleware(['auth'])->group(function () {
    // Ordinance Management Routes
    Route::prefix('ordinances')->group(function () {
        Route::get('/upload', [AdminOrdinanceController::class, 'create'])->name('ord-upload');
        Route::post('/upload', [AdminOrdinanceController::class, 'store'])->name('ord-upload.store');
        Route::get('/uploaded', [AdminOrdinanceController::class, 'index'])->name('ord-uploaded');
        Route::get('/{id}/description', [AdminOrdinanceController::class, 'show'])->name('ord-description');
        Route::get('/{id}/edit', [AdminOrdinanceController::class, 'edit'])->name('ord-edit');
        Route::put('/{id}', [AdminOrdinanceController::class, 'update'])->name('ord-update');
        Route::delete('/{id}', [AdminOrdinanceController::class, 'destroy'])->name('ord-delete');
    });

    // Officials Management Routes
    Route::prefix('officials')->group(function () {
        Route::post('/store', [AdminOfficialController::class, 'store'])->name('admin.officials.store');
    });
});
