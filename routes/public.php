<?php

use Illuminate\Support\Facades\Route;


Route::get('/', fn() => view('index'));

Route::view('registrati', 'sicurezza.registrati');
Route::view('registrazione_ok', 'sicurezza.registrazione_ok');
Route::view('registrazione_no', 'sicurezza.registrazione_no');

Route::view('privacy', 'public.privacy-policy');
Route::view('coockie', 'public.coockie-policy');

Route::view('aree-tematiche', 'public.aree-tematiche');
Route::view('materie/{id_at}', 'public.materie');
Route::view('corsi/{id_materia}', 'public.corsi');
Route::view('corso/{id}', 'public.corso');

Route::view('presentazione-lezione/{id_lezione}/{id_corso}', 'public.presentazione-lezione');
Route::view('visualizza-lezione/{id_lezione}/{id_corso}', 'public.contenuto-lezione');
Route::view('traccia-esercizio/{id_esercizio}/{id_corso}', 'public.traccia-esercizio');

Route::view('lezione-su-richiesta', 'public.lezione-su-richiesta');
Route::view('esito-lez-rich', 'public.esito-lez-rich');

Route::view('informazioni', 'public.informazioni');
Route::view('recupera-password', 'public.recupera-password');
