<?php

use App\Http\Controllers\FileUpload\FileUploadController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/upload', [FileUploadController::class, 'upload'])->name('file.upload');

    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});
