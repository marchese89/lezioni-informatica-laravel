# Lezioni Informatica – Laravel Project

Applicazione web sviluppata con Laravel per la gestione di studenti, lezioni ed esercizi, pensata per supportare l’attività di un insegnante freelance.

## 📌 Descrizione

Questo progetto nasce come base per una piattaforma dedicata alla vendita e gestione di lezioni private di informatica.
L’applicazione consente a uno studente di acquistare lezioni, esercizi e richiedere contenuti personalizzati, mentre l’insegnante (admin) gestisce l’offerta e monitora le attività.

Attualmente il progetto è utilizzato come portfolio tecnico.

---

## 👥 Tipologie di utenti

* **Admin (insegnante)**

  * Gestisce lezioni ed esercizi
  * Imposta prezzi
  * Visualizza richieste degli studenti

* **Studente**

  * Acquista lezioni ed esercizi
  * Invia richieste personalizzate
  * Accede ai contenuti acquistati

---

## ⚙️ Funzionalità principali

* Gestione lezioni ed esercizi con prezzo
* Sistema di acquisto
* Integrazione pagamenti con Stripe
* Generazione e invio fatture via email
* Sistema di autenticazione personalizzato (due ruoli)
* Chat in tempo reale (Laravel Reverb – opzionale)

---

## 🧱 Stack tecnologico

* **Backend:** Laravel 10
* **Database:** MySQL
* **Frontend:** Blade + Bootstrap + JavaScript
* **Pagamenti:** Stripe
* **Realtime:** Laravel Reverb (WebSocket)

---

## 🚀 Installazione

Clona il repository:

```bash
git clone https://github.com/marchese89/lezioni-informatica-laravel.git
cd lezioni-informatica-laravel
```

Installa le dipendenze:

```bash
composer install
```

Configura l’ambiente:

```bash
cp .env.example .env
php artisan key:generate
```

Configura il database nel file `.env`, poi esegui:

```bash
php artisan migrate
```

---

## 💬 Chat in tempo reale (opzionale)

La chat utilizza Laravel Reverb e richiede l’avvio manuale del server WebSocket:

```bash
php artisan reverb:start
```

> Nota: questa funzionalità potrebbe non essere compatibile con hosting condivisi (es. Aruba).

---

## 💳 Pagamenti

Il sistema utilizza Stripe per la gestione dei pagamenti.
È necessario configurare le chiavi API nel file `.env`.

---

## 📦 Stato del progetto

* ✔ Funzionale a livello core
* ⚠️ Alcune funzionalità (chat realtime) non ottimizzate per ambienti di produzione condivisi
* 🎯 Attualmente utilizzato come progetto portfolio

---

## 🎯 Obiettivi del progetto

* Dimostrare competenze nello sviluppo con Laravel
* Gestione completa di un flusso reale (prodotti → pagamento → fatturazione)
* Personalizzazione del sistema di autenticazione
* Integrazione con servizi esterni (Stripe, WebSocket)

---

## 🔧 Possibili miglioramenti

* Introduzione di un sistema di calendario per le lezioni
* Miglioramento della gestione ruoli (es. policy più strutturate)
* Refactoring della chat per ambienti serverless o polling fallback
* UI/UX più moderna

---

## 👤 Autore

Giovanni Marchese
[GitHub](https://github.com/marchese89)

---
