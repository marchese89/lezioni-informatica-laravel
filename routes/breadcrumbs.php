<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


Breadcrumbs::for('dashboard-admin', function (BreadcrumbTrail $trail) {

    $trail->push('Dashboard', route('dashboard-admin'));
});
Breadcrumbs::for('imp-account', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard-admin');
    $trail->push('Impostazioni account', route('imp-account'));
});
Breadcrumbs::for('mod-dati-pers', function (BreadcrumbTrail $trail) {
    $trail->parent('imp-account');
    $trail->push('Modifica dati personali', route('mod-dati-pers'));
});
Breadcrumbs::for('mod-cred', function (BreadcrumbTrail $trail) {
    $trail->parent('imp-account');
    $trail->push('Modifica credenziali', route('mod-cred'));
});
Breadcrumbs::for('mod-foto-admin', function (BreadcrumbTrail $trail) {
    $trail->parent('mod-dati-pers');
    $trail->push('Modifica foto', route('mod-foto-admin'));
});
Breadcrumbs::for('mod-indirizzo-admin', function (BreadcrumbTrail $trail) {
    $trail->parent('mod-dati-pers');
    $trail->push('Modifica indirizzo', route('mod-indirizzo-admin'));
});
Breadcrumbs::for('mod-certif', function (BreadcrumbTrail $trail) {
    $trail->parent('mod-dati-pers');
    $trail->push('Modifica certificati', route('mod-certif'));
});
Breadcrumbs::for('aggiungi-certif', function (BreadcrumbTrail $trail) {
    $trail->push('Aggiungi certificato', route('aggiungi-certif'));
});

Breadcrumbs::for('extra-fattura', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard-admin');
    $trail->push('Fattura extra', route('extra-fattura'));
});

Breadcrumbs::for('fatture', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard-admin');
    $trail->push('Fatture', route('fatture'));
});

Breadcrumbs::for('visualizza-fattura', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('fatture');
    $trail->push('Visualizza fattura', route('visualizza-fattura', $id));
});

Breadcrumbs::for('vendite', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard-admin');
    $trail->push('Vendite', route('vendite'));
});

Breadcrumbs::for('mod-part-iva', function (BreadcrumbTrail $trail) {
    $trail->parent('mod-dati-pers');
    $trail->push('Modifica Partita IVA', route('mod-part-iva'));
});

Breadcrumbs::for('insegnamento', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard-admin');
    $trail->push('Insegnamento', route('insegnamento'));
});
Breadcrumbs::for('nuovo-corso', function (BreadcrumbTrail $trail) {
    $trail->parent('insegnamento');
    $trail->push('Nuovo corso', route('nuovo-corso'));
});
Breadcrumbs::for('aree-tem', function (BreadcrumbTrail $trail) {
    $trail->parent('insegnamento');
    $trail->push('Aree tematiche', route('aree-tem'));
});

Breadcrumbs::for('materie', function (BreadcrumbTrail $trail) {
    $trail->parent('insegnamento');
    $trail->push('Materie', route('materie'));
});
Breadcrumbs::for('elenco-corsi', function (BreadcrumbTrail $trail) {
    $trail->parent('insegnamento');
    $trail->push('Elenco corsi', route('elenco-corsi'));
});

Breadcrumbs::for('modifica-dettagli-corso', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('elenco-corsi');
    $trail->push('Modifica dettagli corso', route('modifica-dettagli-corso', $id));
});

Breadcrumbs::for('nuova-lezione', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('modifica-dettagli-corso', $id);
    $trail->push('Nuova lezione', route('nuova-lezione', $id));
});

Breadcrumbs::for('dashboard-studente', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard-studente'));
});

Breadcrumbs::for('imp-account-studente', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard-studente');
    $trail->push('Impostazioni account', route('imp-account-studente'));
});

Breadcrumbs::for('mod-dati-pers-stud', function (BreadcrumbTrail $trail) {
    $trail->parent('imp-account-studente');
    $trail->push('Modifica dati personali', route('mod-dati-pers-stud'));
});

Breadcrumbs::for('mod-cred-stud', function (BreadcrumbTrail $trail) {
    $trail->parent('imp-account-studente');
    $trail->push('Modifica credenziali', route('mod-cred-stud'));
});
