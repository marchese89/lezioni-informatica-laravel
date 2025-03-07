<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrazioneController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\ModDatiAdminController;
use App\Http\Controllers\Admin\CorsiController;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Files\FileAccessController;
use App\Http\Controllers\AcquistiController;
use App\Http\Controllers\Public\LessonOnRequestController;
use App\Http\Controllers\Student\StudenteController;

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

Route::get('privacy',function(){
    return view('public.privacy-policy');
});

Route::get('coockie',function(){
    return view('public.coockie-policy');
});

Route::post('registrati', [RegistrazioneController::class, 'carica_utente']);

Route::get('login', function () {
    return view('sicurezza.login');
})->name('login');

Route::get('login-{back}', function () {
    return view('sicurezza.login');
})->name('login');

Route::post('login', [LoginController::class, 'login']);

Route::get('logout', [LogoutController::class, 'logout']);

Route::get('aree-tematiche', function () {
    return view('public.aree-tematiche');
});

Route::get('materie-{id_at}', function () {
    return view('public.materie');
});

Route::get('corsi-{id_materia}', function () {
    return view('public.corsi');
});

Route::get('corso-{id}', function () {
    return view('public.corso');
});

Route::get('presentazione-lezione-{id_lezione}-{id_corso}', function () {
    return view('public.presentazione-lezione');
});

Route::get('visualizza-lezione-{id_lezione}-{id_corso}', function () {
    return view('public.contenuto-lezione');
});

Route::get('traccia-esercizio-{id_esercizio}-{id_corso}', function () {
    return view('public.traccia-esercizio');
});

Route::get('lezione-su-richiesta', function () {
    return view('public.lezione-su-richiesta');
});

Route::post('add-file-su-richiesta',[LessonOnRequestController::class,'add_file_su_richiesta']);

Route::get('elimina-lez-rich',[LessonOnRequestController::class,'elimina_lez_rich']);

Route::post('carica-lez-rich',[LessonOnRequestController::class,'carica_lez_rich']);

Route::get('esito-lez-rich',function(){
    return view('public.esito-lez-rich');
});

Route::get('informazioni',function(){
    return view('public.informazioni');
});

Route::get('recupera-password',function(){
    return view('public.recupera-password');
});

Route::post('recupera-password',[LoginController::class,'recupera_password']);

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dashboard-admin', function () {
        return view('admin.dashboard-admin');
    });
    Route::get('imp-account', function () {
        return view('admin.imp-account');
    });
    Route::get('mod-dati-pers', function () {
        return view('admin.mod-dati-pers');
    });

    Route::get('mod-cred', function () {
        return view('admin.mod-cred');
    });

    Route::get('mod-foto-admin', function () {
        return view('admin.mod-foto');
    });

    Route::get('mod-indirizzo-admin', function () {
        return view('admin.mod-indirizzo');
    });


    Route::get('mod-certif', function () {
        return view('admin.mod-certif');
    });

    Route::get('aggiungi-certif', function () {
        return view('admin.add-certif');
    });

    Route::get('insegnamento', function () {
        return view('admin.insegnamento');
    });

    Route::get('nuovo-corso', function () {
        return view('admin.nuovo-corso');
    });

    Route::get('aree-tem', function () {
        return view('admin.aree-tem');
    });

    Route::get('materie', function () {
        return view('admin.materie');
    });

    Route::get('elenco-corsi', function () {
        return view('admin.elenco-corsi');
    });


    Route::post('mod-indirizzo-admin', [ModDatiAdminController::class, 'mod_ind']);

    Route::post('upload-foto-admin', [ModDatiAdminController::class, 'upload_foto']);

    Route::post('mod-foto-cert-admin', [ModDatiAdminController::class, 'upload_cert']);

    Route::post('crea-foto-cert-admin', [ModDatiAdminController::class, 'upload_cert_session']);

    Route::post('mod-nome-cert-admin', [ModDatiAdminController::class, 'modifica_nome_cert']);

    Route::post('elimina_certificato', [ModDatiAdminController::class, 'elimina_cert']);

    Route::get('del_cert_admin', [ModDatiAdminController::class, 'elimina_cert_session']);

    Route::post('add-cert-admin', [ModDatiAdminController::class, 'add_cert_admin']);

    Route::post('mod-email-admin', [ModDatiAdminController::class, 'mod_email_admin']);

    Route::post('mod-pass-admin', [ModDatiAdminController::class, 'mod_pass_admin']);

    Route::post('nuova-a-t', [CorsiController::class, 'nuova_area_tematica']);

    Route::post('modifica-a-t', [CorsiController::class, 'modifica_area_tematica']);

    Route::post('elimina-a-t', [CorsiController::class, 'elimina_area_tematica']);

    Route::post('nuova-mat', [CorsiController::class, 'nuova_materia']);

    Route::post('modifica-mat', [CorsiController::class, 'modifica_materia']);

    Route::post('elimina-mat', [CorsiController::class, 'elimina_materia']);

    Route::post('nuovo-corso', [CorsiController::class, 'nuovo_corso']);

    Route::post('modifica-corso', [CorsiController::class, 'modifica_corso']);

    Route::post('elimina-corso', [CorsiController::class, 'elimina_corso']);

    Route::get('modifica-dettagli-corso-{id}', function () {
        return view('admin.modifica-corso');
    });

    //Lezioni
    Route::get('nuova-lezione-{id}', function () {
        return view('admin.nuova-lezione');
    });

    // Inserimento Lezione
    Route::post('upload-pres-lez', [CorsiController::class, 'upload_pres_lez']);

    Route::get('cancella-file-sessione-{id}', [CorsiController::class, 'cancella_file_sessione']);

    Route::post('upload-lesson', [CorsiController::class, 'upload_lesson']);

    Route::get('cancella-file-lezione-sessione-{id}', [CorsiController::class, 'cancella_file_sessione_lezione']);

    Route::post('carica-lezione', [CorsiController::class, 'carica_lezione']);

    //eliminazione lezione

    Route::post('elimina-lezione', [CorsiController::class, 'elimina_lezione']);

    //modifica lezione

    Route::get('modifica-lezione-{id_corso}-{id_lezione}', function () {
        return view('admin.modifica-lezione');
    });

    Route::post('re-upload-pres-lez', [CorsiController::class, 're_upload_pres_lez']);

    Route::post('re-upload-lesson', [CorsiController::class, 're_upload_lesson']);

    Route::post('modifica-lezione', [CorsiController::class, 'modifica_lezione']);

    //ESERCIZI
    Route::get('nuovo-esercizio-{id}', function () {
        return view('admin.nuovo-esercizio');
    });

    // Inserimento Esercizio
    Route::post('upload-trace-ex', [CorsiController::class, 'upload_trace_ex']);

    Route::get('cancella-file-trace-sessione-{id}', [CorsiController::class, 'cancella_file_sessione_trace_ex']);

    Route::post('upload-ex', [CorsiController::class, 'upload_ex']);

    Route::get('cancella-file-execution-sessione-ex-{id}', [CorsiController::class, 'cancella_file_sessione_ex']);

    Route::post('carica-esercizio', [CorsiController::class, 'carica_esercizio']);

    //eliminazione esercizio

    Route::post('elimina-esercizio', [CorsiController::class, 'elimina_esercizio']);

    //modifica esercizio

    Route::get('modifica-esercizio-{id_corso}-{id_esercizio}', function () {
        return view('admin.modifica-esercizio');
    });

    Route::post('trace-ex-re-upload', [CorsiController::class, 're_upload_trace_ex']);

    Route::post('ex-re-upload', [CorsiController::class, 're_upload_ex']);

    Route::post('modifica-esercizio', [CorsiController::class, 'modifica_esercizio']);

    Route::get('studenti',function(){
        return view('admin.studenti');
    });

    Route::get('richieste-studenti',function(){
        return view('admin.richieste-studenti');
    });

    Route::get('visualizza-richiesta-{id}',function(){
        return view('admin.visualizza-richiesta-lezione');
    });

    Route::post('sol-rich-upload',[LessonOnRequestController::class,'sol_rich_upload']);

    Route::get('lez-rich-rem-exec-{id}',[LessonOnRequestController::class,'lez_rich_rem_exec']);

    Route::post('carica-prezzo-lez-rich',[LessonOnRequestController::class,'carica_prezzo_lez_rich']);

    Route::get('vendite',function(){
        return view('admin.vendite');
    });

    Route::get('admin-ordine-{id}',function(){
        return view('admin.ordine');
    });

    Route::get('admin-fattura-{id}',function(){
        return view('admin.fattura');
    });

    Route::get('cambia_tabella_ordini',[AjaxController::class,'cambia_tabella_ordini']);

    Route::get('chat-studenti',function(){
        return view('admin.chat-studenti');
    });

    Route::get('visualizza-chat-{id}',function(){
        return view('admin.visualizza-chat');
    });

    Route::get('admin-invia-messaggio-{id_chat}-{aut}-{testo}',[AjaxController::class,'invia_messaggio']);

    Route::get('leggi-messaggi-insegnante-{id_chat}',[AjaxController::class,'leggi_messaggi']);

    Route::get('fattura-extra',function(){
        return view('admin.fattura-extra');
    });

    Route::post('crea_fattura_extra',[AcquistiController::class,'crea_fattura']);

    Route::get('fattura-creata',function(){
        return view('admin.fattura-creata');
    });

    Route::get('fatture',function(){
        return view('admin.fatture');
    });

    Route::get('visualizza-fattura-{id}',function(){
        return view('admin.visualizza-fattura');
    });

    Route::get('mod-part-iva',function(){
        return view('admin.mod-part-iva');
    });

    Route::post('mod-piva',[ModDatiAdminController::class,'mod_piva']);

});

Route::get('/protected_file/{path}', [FileAccessController::class, '__invoke']);


Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('dashboard-studente', function () {
        return view('studente.dashboard-studente');
    });

    Route::get('aggiungi-al-carrello-{id}-{type}', [AcquistiController::class, 'aggiungi_al_carrello']);

    Route::get('visualizza-carrello', function () {
        return view('public.visualizza-carrello');
    });

    Route::get('rimuovi-dal-carrello-{id}-{type}', [AcquistiController::class, 'rimuovi_dal_carrello']);

    Route::get('acquista', function () {
        return view('public.acquista');
    });

    Route::get('process-payment', [AcquistiController::class, 'process_payment']);

    Route::get('acquisto-effettuato', [AcquistiController::class, 'processa_acquisto']);

    Route::get('acquisto-a-buon-fine', function () {
        return view('public.acquisto-effettuato');
    });

    Route::get('imp-account-studente',function(){
        return view('studente.impostazioni-account');
    });

    Route::get('mod-dati-pers-stud',function(){
        return view('studente.mod-dati-pers');
    });

    Route::post('mod-indirizzo-stud',[StudenteController::class,'mod_indirizzo_stud']);

    Route::get('mod-cred-stud',function(){
        return view('studente.mod-cred');
    });

    Route::post('mod-email-stud',[StudenteController::class,'mod_email_stud']);

    Route::post('mod-pass-stud',[StudenteController::class,'mod_pass_stud']);

    Route::get('corsi',function(){
        return view('studente.elenco-corsi');
    });

    Route::get('visualizza-corso-{id}',function(){
        return view('studente.corso');
    });

    Route::get('lezione-{id_corso}-{id_lezione}', function () {
        return view('studente.lezione');
    });

    Route::get('esercizio-{id_corso}-{id_esercizio}', function () {
        return view('studente.esercizio');
    });

    Route::get('richieste-dirette',function(){
        return view('studente.richieste-dirette');
    });

    Route::get('stud-visualizza-richiesta-{id}',function(){
        return view('studente.visualizza-richiesta-lezione');
    });

    Route::get('richieste-dirette-acquistate',function(){
        return view('studente.richieste-dirette-acquistate');
    });

    Route::get('ordini',function(){
        return view('studente.ordini');
    });

    Route::get('ordine-{id}',function(){
        return view('studente.ordine');
    });

    Route::get('fattura-{id}',function(){
        return view('studente.fattura');
    });

    Route::get('cambia_tabella_ordini_studente',[AjaxController::class,'cambia_tabella_ordini_studente']);

    Route::get('leggi-messaggi-studente-{id_chat}',[AjaxController::class,'leggi_messaggi_stud']);

    Route::get('studente-invia-messaggio-{id_chat}-{aut}-{testo}',[AjaxController::class,'invia_messaggio']);

    Route::get('recensione',function(){
        return view('studente.recensione');
    });

    Route::get('invia-feedback-{punteggio}',[AjaxController::class,'invia_feedback']);

    Route::get('invia-recensione-{testo}',[AjaxController::class,'invia_recensione']);

    Route::get('pagamento-extra',function(){
        return view('studente.pagamento-extra');
    });

    Route::post('prepara-pagamento',[AcquistiController::class,'prepara_pagamento']);

    Route::get('processa_pagamento',[AcquistiController::class,'processa_pagamento']);

    Route::get('paga',function(){
        return view('studente.paga');
    });

    Route::get('pagamento-effettuato', [AcquistiController::class, 'acquisto']);

    Route::get('pagamento-ok',function(){
        return view('studente.pagamento-ok');
    });

    Route::get('fatture-studente',function(){
        return view('studente.fatture-studente');
    });

    Route::get('fattura0-studente-{id}',function(){
        return view('studente.fattura-studente');
    });

});
