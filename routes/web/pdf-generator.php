<?php

declare(strict_types=1);

use App\Http\Controllers\PDFGenerator\PDFGeneratorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/pdf-generate', [PDFGeneratorController::class, 'generate'])->name('pdf.generate');
});
