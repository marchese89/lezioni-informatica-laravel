<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrazioneController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\ModDatiAdminController;
use App\Http\Controllers\Admin\CorsiController;
use App\Http\Controllers\Files\FileAccessController;
use App\Http\Controllers\AcquistiController;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;
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

Route::get('aree-tematiche',function(){
    return view('public.aree-tematiche');
});

Route::get('materie-{id_at}',function(){
    return view('public.materie');
});

Route::get('corsi-{id_materia}',function(){
    return view('public.corsi');
});

Route::get('corso-{id}',function(){
    return view('public.corso');
});

Route::get('presentazione-lezione-{id_lezione}-{id_corso}',function(){
    return view('public.presentazione-lezione');
});

Route::get('visualizza-lezione-{id_lezione}-{id_corso}',function(){
    return view('public.contenuto-lezione');
});

Route::get('traccia-esercizio-{id_esercizio}-{id_corso}',function(){
    return view('public.traccia-esercizio');
});

Route::get('aggiungi-al-carrello-{id}-{type}',[AcquistiController::class,'aggiungi_al_carrello']);

Route::get('visualizza-carrello',function(){
    return view('public.visualizza-carrello');
});

Route::get('rimuovi-dal-carrello-{id}-{type}',[AcquistiController::class,'rimuovi_dal_carrello']);

Route::get('acquista',function(){
    return view('public.acquista');
});


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

    Route::get('mod-cred', function ()    {
        return view('admin.mod-cred');
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

    Route::get('aggiungi-certif',function(){
        return view('admin.add-certif');
    });

    Route::get('insegnamento',function(){
        return view('admin.insegnamento');
    });

    Route::get('nuovo-corso',function(){
        return view('admin.nuovo-corso');
    });

    Route::get('aree-tem',function(){
        return view('admin.aree-tem');
    });

    Route::get('materie',function(){
        return view('admin.materie');
    });

    Route::get('elenco-corsi',function(){
        return view('admin.elenco-corsi');
    });


    Route::post('mod-indirizzo-admin', [ModDatiAdminController::class,'mod_ind']);

    Route::post('upload-foto-admin',[ModDatiAdminController::class,'upload_foto']);

    Route::post('mod-chiave-stripe',[ModDatiAdminController::class,'modifica_chiave']);

    Route::post('mod-foto-cert-admin',[ModDatiAdminController::class,'upload_cert']);

    Route::post('crea-foto-cert-admin',[ModDatiAdminController::class,'upload_cert_session']);

    Route::post('mod-nome-cert-admin',[ModDatiAdminController::class,'modifica_nome_cert']);

    Route::post('elimina_certificato',[ModDatiAdminController::class,'elimina_cert']);

    Route::get('del_cert_admin',[ModDatiAdminController::class,'elimina_cert_session']);

    Route::post('add-cert-admin',[ModDatiAdminController::class,'add_cert_admin']);

    Route::post('mod-email-admin',[ModDatiAdminController::class,'mod_email_admin']);

    Route::post('mod-pass-admin',[ModDatiAdminController::class,'mod_pass_admin']);

    Route::post('nuova-a-t',[CorsiController::class,'nuova_area_tematica']);

    Route::post('modifica-a-t', [CorsiController::class,'modifica_area_tematica']);

    Route::post('elimina-a-t', [CorsiController::class,'elimina_area_tematica']);

    Route::post('nuova-mat',[CorsiController::class,'nuova_materia']);

    Route::post('modifica-mat',[CorsiController::class,'modifica_materia']);

    Route::post('elimina-mat',[CorsiController::class,'elimina_materia']);

    Route::post('nuovo-corso',[CorsiController::class,'nuovo_corso']);

    Route::post('modifica-corso',[CorsiController::class,'modifica_corso']);

    Route::post('elimina-corso',[CorsiController::class,'elimina_corso']);

    Route::get('modifica-dettagli-corso-{id}',function(){
        return view('admin.modifica-corso');
    });

    //Lezioni
    Route::get('nuova-lezione-{id}',function(){
        return view('admin.nuova-lezione');
    });

    // Inserimento Lezione
    Route::post('upload-pres-lez',[CorsiController::class,'upload_pres_lez']);

    Route::get('cancella-file-sessione-{id}',[CorsiController::class, 'cancella_file_sessione']);

    Route::post('upload-lesson',[CorsiController::class,'upload_lesson']);

    Route::get('cancella-file-lezione-sessione-{id}',[CorsiController::class, 'cancella_file_sessione_lezione']);

    Route::post('carica-lezione',[CorsiController::class, 'carica_lezione']);

    //eliminazione lezione

    Route::post('elimina-lezione',[CorsiController::class,'elimina_lezione']);

    //modifica lezione

    Route::get('modifica-lezione-{id_corso}-{id_lezione}',function(){
        return view('admin.modifica-lezione');
    });

    Route::post('re-upload-pres-lez',[CorsiController::class,'re_upload_pres_lez']);

    Route::post('re-upload-lesson',[CorsiController::class,'re_upload_lesson']);

    Route::post('modifica-lezione',[CorsiController::class, 'modifica_lezione']);

    //ESERCIZI
    Route::get('nuovo-esercizio-{id}',function(){
        return view('admin.nuovo-esercizio');
    });

    // Inserimento Esercizio
    Route::post('upload-trace-ex',[CorsiController::class,'upload_trace_ex']);

    Route::get('cancella-file-trace-sessione-{id}',[CorsiController::class, 'cancella_file_sessione_trace_ex']);

    Route::post('upload-ex',[CorsiController::class,'upload_ex']);

    Route::get('cancella-file-execution-sessione-ex-{id}',[CorsiController::class, 'cancella_file_sessione_ex']);

    Route::post('carica-esercizio',[CorsiController::class, 'carica_esercizio']);

    //eliminazione esercizio

    Route::post('elimina-esercizio',[CorsiController::class,'elimina_esercizio']);

    //modifica esercizio

    Route::get('modifica-esercizio-{id_corso}-{id_esercizio}',function(){
        return view('admin.modifica-esercizio');
    });

    Route::post('trace-ex-re-upload',[CorsiController::class,'re_upload_trace_ex']);

    Route::post('ex-re-upload',[CorsiController::class,'re_upload_ex']);

    Route::post('modifica-esercizio',[CorsiController::class, 'modifica_esercizio']);


});

Route::get('/protected_file/{path}', [FileAccessController::class,'__invoke']);


Route::middleware(['auth', 'role:student'] )->group(function(){
    Route::get('dashboard-studente', function ()    {
        return view('studente.dashboard-studente');
    });

});
