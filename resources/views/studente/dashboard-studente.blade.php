@extends('layouts.layout-bootstrap')

@section('content')
    <div id="layoutSidenav">

        <div id="layoutSidenav_nav">
        </div>

        <div id="layoutSidenav_content">
            <main>

                @if (!Request::is('dashboard-studente'))
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
                                    Dashboard Studente
                                </h1>

                                <p class="text-muted mb-0">
                                    Area personale studente
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
                                            Modifica dati personali e password dell’account.
                                        </p>

                                        <a href="{{ url('imp-account-studente') }}"
                                            class="btn btn-primary rounded-pill px-4">
                                            Accedi
                                        </a>

                                    </div>
                                </div>
                            </div>

                            {{-- CORSI --}}
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-body p-4">

                                        <div class="mb-4">
                                            <i class="fa-solid fa-book-open fa-2x text-primary"></i>
                                        </div>

                                        <h4 class="fw-bold mb-3">
                                            Corsi Acquistati
                                        </h4>

                                        <p class="text-muted mb-4">
                                            Lezioni ed esercizi dei corsi acquistati.
                                        </p>

                                        <a href="{{ url('corsi') }}" class="btn btn-primary rounded-pill px-4">
                                            Accedi
                                        </a>

                                    </div>
                                </div>
                            </div>

                            {{-- RICHIESTE DIRETTE --}}
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-body p-4">

                                        <div class="mb-4">
                                            <i class="fa-solid fa-comments fa-2x text-primary"></i>
                                        </div>

                                        <h4 class="fw-bold mb-3">
                                            Richieste Dirette
                                        </h4>

                                        <p class="text-muted mb-4">
                                            Storico richieste e relative informazioni economiche.
                                        </p>

                                        <a href="{{ url('richieste-dirette') }}" class="btn btn-primary rounded-pill px-4">
                                            Accedi
                                        </a>

                                    </div>
                                </div>
                            </div>

                            {{-- LEZIONI SU RICHIESTA --}}
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-body p-4">

                                        <div class="mb-4">
                                            <i class="fa-solid fa-chalkboard-teacher fa-2x text-primary"></i>
                                        </div>

                                        <h4 class="fw-bold mb-3">
                                            Lezioni su Richiesta
                                        </h4>

                                        <p class="text-muted mb-4">
                                            Materiali e contenuti acquistati su richiesta.
                                        </p>

                                        <a href="{{ url('richieste-dirette-acquistate') }}"
                                            class="btn btn-primary rounded-pill px-4">
                                            Accedi
                                        </a>

                                    </div>
                                </div>
                            </div>

                            {{-- ORDINI --}}
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-body p-4">

                                        <div class="mb-4">
                                            <i class="fa-solid fa-box fa-2x text-primary"></i>
                                        </div>

                                        <h4 class="fw-bold mb-3">
                                            Ordini
                                        </h4>

                                        <p class="text-muted mb-4">
                                            Storico e stato degli ordini effettuati.
                                        </p>

                                        <a href="{{ url('ordini') }}" class="btn btn-primary rounded-pill px-4">
                                            Accedi
                                        </a>

                                    </div>
                                </div>
                            </div>

                            {{-- RECENSIONI --}}
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-body p-4">

                                        <div class="mb-4">
                                            <i class="fa-solid fa-star fa-2x text-primary"></i>
                                        </div>

                                        <h4 class="fw-bold mb-3">
                                            Recensione
                                        </h4>

                                        <p class="text-muted mb-4">
                                            Valutazione del servizio e feedback.
                                        </p>

                                        <a href="{{ url('recensione') }}" class="btn btn-primary rounded-pill px-4">
                                            Accedi
                                        </a>

                                    </div>
                                </div>
                            </div>

                            {{-- PAGAMENTI --}}
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-body p-4">

                                        <div class="mb-4">
                                            <i class="fa-solid fa-credit-card fa-2x text-primary"></i>
                                        </div>

                                        <h4 class="fw-bold mb-3">
                                            Pagamento Extra
                                        </h4>

                                        <p class="text-muted mb-4">
                                            Pagamento lezioni private e servizi aggiuntivi.
                                        </p>

                                        <a href="{{ url('/payment/extra') }}" class="btn btn-primary rounded-pill px-4">
                                            Accedi
                                        </a>

                                    </div>
                                </div>
                            </div>

                            {{-- FATTURE --}}
                            <div class="col-xl-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-body p-4">

                                        <div class="mb-4">
                                            <i class="fa-solid fa-file-invoice fa-2x text-primary"></i>
                                        </div>

                                        <h4 class="fw-bold mb-3">
                                            Fatture
                                        </h4>

                                        <p class="text-muted mb-4">
                                            Storico fatture dei pagamenti extra.
                                        </p>

                                        <a href="{{ url('fatture-studente') }}" class="btn btn-primary rounded-pill px-4">
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
