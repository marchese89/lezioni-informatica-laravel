@extends('layouts.layout-bootstrap')

@section('content')
    <div id="layoutSidenav">

        <div id="layoutSidenav_content">
            <main class="py-5" style="background: #f4f6f9; min-height: 100vh;">

                @if (!Request::is('dashboard-admin'))
                    @yield('page-title')
                    <div class="container">
                        {{ Breadcrumbs::render() }}
                    </div>
                    @yield('inner')
                @else
                    <div class="container">

                        {{-- HEADER --}}
                        <div class="d-flex justify-content-between align-items-center mb-5">

                            <div>
                                <h1 class="fw-bold mb-1" style="font-size: 2.5rem;">
                                    Dashboard Admin
                                </h1>

                                <p class="text-muted mb-0">
                                    Gestione piattaforma Lezioni Informatica
                                </p>
                            </div>
                        </div>

                        {{-- CARDS --}}
                        <div class="row g-4">

                            {{-- ACCOUNT --}}
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-body p-4">

                                        <div class="mb-4">
                                            <i class="fa-solid fa-user-gear fa-2x text-primary"></i>
                                        </div>

                                        <h4 class="fw-bold mb-3">
                                            Impostazioni Account
                                        </h4>

                                        <p class="text-muted mb-4">
                                            Modifica dati personali, email e password dell'account amministratore.
                                        </p>

                                        <a href="imp-account" class="btn btn-primary rounded-pill px-4">
                                            Accedi
                                        </a>

                                    </div>
                                </div>
                            </div>

                            {{-- INSEGNAMENTO --}}
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-body p-4">

                                        <div class="mb-4">
                                            <i class="fa-solid fa-graduation-cap fa-2x text-primary"></i>
                                        </div>

                                        <h4 class="fw-bold mb-3">
                                            Insegnamento
                                        </h4>

                                        <p class="text-muted mb-4">
                                            Gestione aree tematiche, materie, corsi, lezioni ed esercizi.
                                        </p>

                                        <a href="insegnamento" class="btn btn-primary rounded-pill px-4">
                                            Accedi
                                        </a>

                                    </div>
                                </div>
                            </div>

                            {{-- STUDENTI --}}
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-body p-4">

                                        <div class="mb-4">
                                            <i class="fa-solid fa-users fa-2x text-primary"></i>
                                        </div>

                                        <h4 class="fw-bold mb-3">
                                            Studenti
                                        </h4>

                                        <p class="text-muted mb-4">
                                            Richieste studenti, gestione chat e monitoraggio attività.
                                        </p>

                                        <a href="studenti" class="btn btn-primary rounded-pill px-4">
                                            Accedi
                                        </a>

                                    </div>
                                </div>
                            </div>

                            {{-- VENDITE --}}
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-body p-4">

                                        <div class="mb-4">
                                            <i class="fa-solid fa-cart-shopping fa-2x text-primary"></i>
                                        </div>

                                        <h4 class="fw-bold mb-3">
                                            Vendite
                                        </h4>

                                        <p class="text-muted mb-4">
                                            Controllo ordini, statistiche e guadagni mensili e totali.
                                        </p>

                                        <a href="vendite" class="btn btn-primary rounded-pill px-4">
                                            Accedi
                                        </a>

                                    </div>
                                </div>
                            </div>

                            {{-- FATTURA EXTRA --}}
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-body p-4">

                                        <div class="mb-4">
                                            <i class="fa-solid fa-file-invoice fa-2x text-primary"></i>
                                        </div>

                                        <h4 class="fw-bold mb-3">
                                            Fattura Extra
                                        </h4>

                                        <p class="text-muted mb-4">
                                            Creazione di fatture personalizzate per attività esterne.
                                        </p>

                                        <a href="extra-fattura" class="btn btn-primary rounded-pill px-4">
                                            Accedi
                                        </a>

                                    </div>
                                </div>
                            </div>

                            {{-- ELENCO FATTURE --}}
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-body p-4">

                                        <div class="mb-4">
                                            <i class="fa-solid fa-file-lines fa-2x text-primary"></i>
                                        </div>

                                        <h4 class="fw-bold mb-3">
                                            Elenco Fatture
                                        </h4>

                                        <p class="text-muted mb-4">
                                            Archivio completo delle fatture emesse dalla piattaforma.
                                        </p>

                                        <a href="fatture" class="btn btn-primary rounded-pill px-4">
                                            Accedi
                                        </a>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                @endif

            </main>
        </div>
    </div>
@endsection
