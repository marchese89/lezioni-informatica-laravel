@extends('layouts.layout-bootstrap')

@section('content')
    <div id="layoutSidenav" >
        <div id="layoutSidenav_nav">

        </div>
        <div id="layoutSidenav_content" >
            <main>

                @if (!Request::is('dashboard-admin'))
                    @yield('inner')
                @else
                    <div class="row g-0 container-fluid">

                        <div class="card col-md-6" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Impostazioni Account</h5>
                                <p class="card-text">Qui si possono modificare i dati personali e la password</p>
                                <a href="imp-account" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>

                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Insegnamento</h5>
                                <p class="card-text">Tutto quello che riguarada l'Insegnamento si trova in questa pagina,
                                    inserimento aree tematiche, materie,
                                    corsi, lezioni ed esercizi
                                </p>
                                <a href="insegnamento" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Studenti</h5>
                                <p class="card-text">In questa sezione ci sono le richieste degli studenti e le pagine di
                                    chat</p>
                                <a href="studenti" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Vendite</h5>
                                <p class="card-text">Qui c'&egrave; tutto quello che riguarada le vendite: ogni singolo
                                    ordine e il totale dei guadagni mensile e totale</p>
                                <a href="vendite" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Fattura Extra</h5>
                                <p class="card-text">Questa sezione &egrave; dedicata alla scrittura di fatture custom per
                                    attività extra</p>
                                <a href="fattura-extra" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Elenco Fatture</h5>
                                <p class="card-text">In questa sezione si trovano tutte le fatture emesse</p>
                                <a href="fatture" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
@endsection
