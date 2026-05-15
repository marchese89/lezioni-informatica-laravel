@extends('admin.dashboard-admin')

@section('page-title')
    <div class="container">
        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h1 class="fw-bold mb-1" style="font-size: 2.5rem;">
                    Impostazioni Account
                </h1>

                <p class="text-muted mb-0">
                    Gestisci dati personali e credenziali amministratore.
                </p>
            </div>
        </div>
    </div>
@endsection

@section('inner')
    <div class="container">
        {{-- CARDS --}}
        <div class="row g-4">

            {{-- DATI PERSONALI --}}
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4 d-flex flex-column">

                        <div class="mb-4">
                            <i class="fa-solid fa-user fa-2x text-primary"></i>
                        </div>

                        <h4 class="fw-bold mb-3">
                            Modifica Dati Personali
                        </h4>

                        <p class="text-muted mb-4 flex-grow-1">
                            Aggiorna informazioni anagrafiche, indirizzo e dati del profilo.
                        </p>

                        <a href="{{ url('mod-dati-pers') }}" class="btn btn-primary rounded-pill px-4">
                            Accedi
                        </a>

                    </div>
                </div>
            </div>

            {{-- CREDENZIALI --}}
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4 d-flex flex-column">

                        <div class="mb-4">
                            <i class="fa-solid fa-shield-halved fa-2x text-primary"></i>
                        </div>

                        <h4 class="fw-bold mb-3">
                            Modifica Credenziali
                        </h4>

                        <p class="text-muted mb-4 flex-grow-1">
                            Gestisci email, password e sicurezza dell’account amministratore.
                        </p>

                        <a href="{{ url('mod-cred') }}" class="btn btn-primary rounded-pill px-4">
                            Accedi
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
