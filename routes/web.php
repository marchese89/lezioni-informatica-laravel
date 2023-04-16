<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrazioneController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/registrati', function () {
    return view('registrati');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/registrati_post',[RegistrazioneController::class, 'carica_utente']);

Route::post('/login_post',[LoginController::class, 'authenticate']);

Route::get('/dashboard-admin', function () {
    return view('dashboard-admin');
});

Route::get('/dashboard-studente', function () {
    return view('dashboard-studente');
});

