@extends('layouts.layout-bootstrap')

@section('content')
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading" onclick="location.href='dashboard-admin'" style="cursor: pointer">
                            Studente</div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fa solid fa-gear"></i></div>
                            Imp. Account
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="mod-dati-pers">Modifica Dati personali</a>
                                <a class="nav-link" href="#">Modifica Credenziali</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Corsi
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth">
                                    Authentication
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="login.html">Login</a>
                                        <a class="nav-link" href="register.html">Register</a>
                                        <a class="nav-link" href="password.html">Forgot Password</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseError" aria-expanded="false"
                                    aria-controls="pagesCollapseError">
                                    Error
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="401.html">401 Page</a>
                                        <a class="nav-link" href="404.html">404 Page</a>
                                        <a class="nav-link" href="500.html">500 Page</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>

                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="tables.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                    </div>
                </div>
            </nav>
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
                                <p class="card-text">Qui si trovano tutti i corsi aquistati, comprensivi di lezioni ed esercizi
                                </p>
                                <a href="corsi" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Richieste Dirette</h5>
                                <p class="card-text">Qui ci sono le richieste dirette già fatte, con i relativi prezzi di vendita</p>
                                <a href="richieste-dirette" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Lezioni su Richiesta Acquistate</h5>
                                <p class="card-text">In questa sezione ci sono le lezioni/gli esercizi su richiesta già acquistate/i</p>
                                <a href="richieste-dirette-acquistate" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                        <div class="card" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Ordini</h5>
                                <p class="card-text">Questa sezione &egrave; dedicata agli Ordini</p>
                                <a href="#" class="btn btn-primary">Accedi</a>
                            </div>
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
@endsection
