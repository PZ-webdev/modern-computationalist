<?php

use App\Http\Controllers\PDFGenerator\PDFGeneratorController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('auth/login');
})->name('auth.login');

require __DIR__ . '/web/auth.php';
require __DIR__ . '/web/settings.php';
require __DIR__ . '/web/dashboard.php';
require __DIR__ . '/web/pdf-generator.php';
