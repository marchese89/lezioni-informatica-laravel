<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcquistiController;
use App\Http\Controllers\Student\StudenteController;
use App\Http\Controllers\Admin\AjaxController;

Route::middleware(['auth', 'role:student'])->group(function () {

    // =========================
    // DASHBOARD
    // =========================
    Route::view('dashboard-studente', 'studente.dashboard-studente');

    // =========================
    // ACCOUNT (MANCAVA LA COMPATIBILITÀ VECCHIA)
    // =========================
    Route::view('imp-account-studente', 'studente.impostazioni-account');
    Route::view('account', 'studente.impostazioni-account');

    Route::view('mod-dati-pers-stud', 'studente.mod-dati-pers');
    Route::view('mod-cred-stud', 'studente.mod-cred');

    Route::post('mod-indirizzo-stud', [StudenteController::class, 'mod_indirizzo_stud']);
    Route::post('mod-email-stud', [StudenteController::class, 'mod_email_stud']);
    Route::post('mod-pass-stud', [StudenteController::class, 'mod_pass_stud']);

    // =========================
    // CORSI
    // =========================
    Route::view('corsi', 'studente.elenco-corsi');
    Route::view('course/{id}', 'studente.corso');

    Route::view('studente/corso/{id}', 'studente.corso');

    Route::get('lezione/{id_corso}/{id_lezione}', [StudenteController::class, 'lezione']);
    Route::get('esercizio/{id_corso}/{id_esercizio}', [StudenteController::class, 'esercizio']);

    // =========================
    // CARRELLO (NUOVO + VECCHIO COMPATIBILE)
    // =========================
    Route::view('carrello', 'public.visualizza-carrello');

    Route::get('carrello/add/{id}/{type}', [AcquistiController::class, 'aggiungi_al_carrello']);

    Route::delete('carrello/remove/{id}/{type}', [AcquistiController::class, 'rimuovi_dal_carrello']);

    // =========================
    // CHECKOUT / PAGAMENTI
    // =========================
    Route::view('acquista', 'public.acquista');
    Route::view('checkout', 'public.acquista');

    Route::post('prepara-pagamento', [AcquistiController::class, 'prepara_pagamento']);
    Route::post('/payment/process', [AcquistiController::class, 'process_payment']);

    Route::get('processa_pagamento', [AcquistiController::class, 'processa_pagamento']);
    Route::get('payment/success', [AcquistiController::class, 'processa_acquisto']);

    Route::get('acquisto-effettuato', [AcquistiController::class, 'processa_acquisto']);
    Route::get('acquisto-a-buon-fine', function () {
        return view('public.acquisto-effettuato');
    });

    Route::get('paga', function () {
        return view('studente.paga');
    });

    Route::get('pagamento-ok', function () {
        return view('studente.pagamento-ok');
    });

    Route::view('payment/extra', 'studente.pagamento-extra');

    // =========================
    // ORDINI / FATTURE (VECCHIE RIPRISTINATE)
    // =========================
    Route::view('ordini', 'studente.ordini');
    Route::view('ordine-{id}', 'studente.ordine');

    Route::view('fatture-studente', 'studente.fatture-studente');
    Route::view('fattura-{id}', 'studente.fattura');

    Route::view('fattura0-studente-{id}', 'studente.fattura-studente');

    // =========================
    // RICHIESTE DIRETTE
    // =========================
    Route::view('richieste-dirette', 'studente.richieste-dirette');
    Route::view('richieste-dirette-acquistate', 'studente.richieste-dirette-acquistate');
    Route::view('stud-visualizza-richiesta-{id}', 'studente.visualizza-richiesta-lezione');

    // =========================
    // CHAT
    // =========================
    Route::get('chat/{id_chat}/messaggi', [AjaxController::class, 'leggi_messaggi_stud']);

    Route::post('chat/studente/invia-messaggio', [AjaxController::class, 'invia_messaggio']);

    // =========================
    // FEEDBACK / RECENSIONI
    // =========================
    Route::view('recensione', 'studente.recensione');

    Route::get('invia-feedback-{punteggio}', [AjaxController::class, 'invia_feedback']);
    Route::get('invia-recensione-{testo}', [AjaxController::class, 'invia_recensione']);

    // =========================
    // AJAX VARI
    // =========================
    Route::get('cambia_tabella_ordini_studente', [AjaxController::class, 'cambia_tabella_ordini_studente']);
});
