<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Files\FileAccessController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================
// ROUTE MODULARI
// =========================

require __DIR__ . '/public.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/student.php';

// =========================
// ADMIN (protetto)
// =========================

Route::middleware(['auth', 'role:admin'])
    ->group(function () {
        require __DIR__ . '/admin.php';
    });

// =========================
// FILE PROTETTI
// =========================

Route::get('/protected_file/{path}', FileAccessController::class)
    ->where('path', '.*');
