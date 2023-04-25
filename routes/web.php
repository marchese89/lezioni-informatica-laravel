<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrazioneController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\UploadPhotoAdminController;
use App\Http\Controllers\Admin\ModIndAdminController;
use App\Http\Controllers\Admin\ModChiaveStripeController;
use App\Http\Controllers\Admin\ModCertAdminController;
use App\Http\Controllers\Admin\ModNomeCertAdminController;

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



Route::get('registrati', function () {
    return view('sicurezza.registrati');
});

Route::get('registrazione_ok', function () {
    return view('sicurezza.registrazione_ok');
});

Route::get('registrazione_no', function () {
    return view('sicurezza.registrazione_no');
});


Route::post('registrati',[RegistrazioneController::class, 'carica_utente']);

Route::get('login', function () {
    return view('sicurezza.login');
})->name('login');

Route::post('login',[LoginController::class,'login']);

Route::get('logout',[LogoutController::class,'logout']);


Route::middleware(['auth', 'role:admin'] )->group(function(){
    Route::get('dashboard-admin', function ()    {
        return view('admin.dashboard-admin');
    });
    Route::get('imp-account', function ()    {
        return view('admin.imp-account');
    });
    Route::get('mod-dati-pers', function ()    {
        return view('admin.mod-dati-pers');
    });

    Route::get('mod-foto-admin', function ()    {
        return view('admin.mod-foto');
    });

    Route::get('mod-indirizzo-admin', function ()    {
        return view('admin.mod-indirizzo');
    });

    Route::get('mod-chiave-priv-stripe',function(){
        return view('admin.mod-chiave-priv-stripe');
    });

    Route::get('mod-certif',function(){
        return view('admin.mod-certif');
    });

    Route::post('mod-indirizzo-admin', [ModIndAdminController::class,'mod_ind']);

    Route::post('upload-foto-admin',[UploadPhotoAdminController::class,'upload']);

    Route::post('mod-chiave-stripe',[ModChiaveStripeController::class,'modifica']);

    Route::post('mod-foto-cert-admin',[ModCertAdminController::class,'upload']);

    Route::post('mod-nome-cert-admin',[ModNomeCertAdminController::class,'modifica']);

});

Route::middleware(['auth', 'role:student'] )->group(function(){
    Route::get('dashboard-studente', function ()    {
        return view('studente.dashboard-studente');
    });

});
