<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistrazioneController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

Route::view('login', 'sicurezza.login')->name('login');

Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LogoutController::class, 'logout']);

Route::post('registrati', [RegistrazioneController::class, 'carica_utente']);
Route::post('recupera-password', [LoginController::class, 'recupera_password']);
