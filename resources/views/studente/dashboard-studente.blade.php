@extends('layouts.layout-bootstrap')

@section('content')
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">

        </div>
        <div id="layoutSidenav_content">
            <main>

                @if (!Request::is('dashboard-studente'))
                    @yield('inner')
                @else
                    <div class="row g-0 container-fluid">

                        <div class="card col-md-6" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Impostazioni Account</h5>
                                <p class="card-text">Qui si possono modificare i dati personali e la password</p>
                                <a href="imp-account-studente" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>

                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Corsi Acquistati</h5>
                                <p class="card-text">Qui si trovano tutti i corsi aquistati, comprensivi di lezioni ed
                                    esercizi
                                </p>
                                <a href="corsi" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Richieste Dirette</h5>
                                <p class="card-text">Qui ci sono le richieste dirette già fatte, con i relativi prezzi di
                                    vendita</p>
                                <a href="richieste-dirette" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Lezioni su Richiesta Acquistate</h5>
                                <p class="card-text">In questa sezione ci sono le lezioni/gli esercizi su richiesta già
                                    acquistate/i</p>
                                <a href="richieste-dirette-acquistate" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Ordini</h5>
                                <p class="card-text">Questa sezione &egrave; dedicata agli Ordini</p>
                                <a href="ordini" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Recensione</h5>
                                <p class="card-text">In questa sezione si può lasciare una recensione con voto sul servizio
                                </p>
                                <a href="recensione" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Pagamento Extra</h5>
                                <p class="card-text">Questa sezione serve per pagare le lezioni private
                                </p>
                                <a href="pagamento-extra" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Fatture</h5>
                                <p class="card-text">Fatture relative ai pagamenti extra (lezioni private)
                                </p>
                                <a href="fatture-studente" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
@endsection
