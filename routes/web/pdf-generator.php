<?php

use App\Http\Controllers\PDFGenerator\PDFGeneratorController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/pdf-generate', [PDFGeneratorController::class, 'generate'])->name('pdf.generate');
});
