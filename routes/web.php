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

Route::get('privacy', function () {
    return view('public.privacy-policy');
});

Route::get('coockie', function () {
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

Route::post('add-file-su-richiesta', [LessonOnRequestController::class, 'add_file_su_richiesta']);

Route::get('elimina-lez-rich', [LessonOnRequestController::class, 'elimina_lez_rich']);

Route::post('carica-lez-rich', [LessonOnRequestController::class, 'carica_lez_rich']);

Route::get('esito-lez-rich', function () {
    return view('public.esito-lez-rich');
});

Route::get('informazioni', function () {
    return view('public.informazioni');
});

Route::get('recupera-password', function () {
    return view('public.recupera-password');
});

Route::post('recupera-password', [LoginController::class, 'recupera_password']);


Route::middleware(['auth', 'role:admin'])
    ->group(function () {
        require __DIR__ . '/admin.php';
    });

Route::get('/protected_file/{path}', [FileAccessController::class, '__invoke'])->where('path', '.*');


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

    Route::get('imp-account-studente', function () {
        return view('studente.impostazioni-account');
    });

    Route::get('mod-dati-pers-stud', function () {
        return view('studente.mod-dati-pers');
    });

    Route::post('mod-indirizzo-stud', [StudenteController::class, 'mod_indirizzo_stud']);

    Route::get('mod-cred-stud', function () {
        return view('studente.mod-cred');
    });

    Route::post('mod-email-stud', [StudenteController::class, 'mod_email_stud']);

    Route::post('mod-pass-stud', [StudenteController::class, 'mod_pass_stud']);

    Route::get('corsi', function () {
        return view('studente.elenco-corsi');
    });

    Route::get('visualizza-corso-{id}', function () {
        return view('studente.corso');
    });

    Route::get('lezione-{id_corso}-{id_lezione}', function () {
        return view('studente.lezione');
    });

    Route::get('esercizio-{id_corso}-{id_esercizio}', function () {
        return view('studente.esercizio');
    });

    Route::get('richieste-dirette', function () {
        return view('studente.richieste-dirette');
    });

    Route::get('stud-visualizza-richiesta-{id}', function () {
        return view('studente.visualizza-richiesta-lezione');
    });

    Route::get('richieste-dirette-acquistate', function () {
        return view('studente.richieste-dirette-acquistate');
    });

    Route::get('ordini', function () {
        return view('studente.ordini');
    });

    Route::get('ordine-{id}', function () {
        return view('studente.ordine');
    });

    Route::get('fattura-{id}', function () {
        return view('studente.fattura');
    });

    Route::get('cambia_tabella_ordini_studente', [AjaxController::class, 'cambia_tabella_ordini_studente']);

    Route::get('leggi-messaggi-studente-{id_chat}', [AjaxController::class, 'leggi_messaggi_stud']);

    Route::get('studente-invia-messaggio-{id_chat}-{aut}-{testo}', [AjaxController::class, 'invia_messaggio']);

    Route::get('recensione', function () {
        return view('studente.recensione');
    });

    Route::get('invia-feedback-{punteggio}', [AjaxController::class, 'invia_feedback']);

    Route::get('invia-recensione-{testo}', [AjaxController::class, 'invia_recensione']);

    Route::get('pagamento-extra', function () {
        return view('studente.pagamento-extra');
    });

    Route::post('prepara-pagamento', [AcquistiController::class, 'prepara_pagamento']);

    Route::get('processa_pagamento', [AcquistiController::class, 'processa_pagamento']);

    Route::get('paga', function () {
        return view('studente.paga');
    });

    Route::get('pagamento-effettuato', [AcquistiController::class, 'acquisto']);

    Route::get('pagamento-ok', function () {
        return view('studente.pagamento-ok');
    });

    Route::get('fatture-studente', function () {
        return view('studente.fatture-studente');
    });

    Route::get('fattura0-studente-{id}', function () {
        return view('studente.fattura-studente');
    });
});
