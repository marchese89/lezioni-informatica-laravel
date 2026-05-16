@extends('admin.dashboard-admin')

@section('page-title')
    <div class="container mb-3">
        <h2 class="fw-bold mb-1" style="font-size: 2.5rem;">
            Modifica Indirizzo
        </h2>
    </div>
@endsection

@section('inner')
    <div class="container mt-5" style="text-align: center">

        <form class="row g-3" method="POST" action="mod-indirizzo-admin">
            @csrf
            <div class="col-md-5">
                <label class="form-label">Indirizzo (via/piazza)</label>
                <input type="text" class="form-control" id="inputIndirizzo" name="inputIndirizzo" maxlength="255"
                    value="{{ auth()->user()->admin->street }}">
                <script type="text/javascript">
                    var via_ = new LiveValidation('inputIndirizzo', {
                        onlyOnSubmit: true
                    });
                    via_.add(Validate.Presence);
                    via_.add(Validate.SoloTesto);
                </script>
            </div>
            <div class="col-md-1">
                <label class="form-label">N. Civico</label>
                <input type="text" class="form-control" id="inputNumeroCivico" name="inputNumeroCivico" maxlength="6"
                    value="{{ auth()->user()->admin->house_number }}">
                <script type="text/javascript">
                    var n_civico_ = new LiveValidation('inputNumeroCivico', {
                        onlyOnSubmit: true
                    });
                    n_civico_.add(Validate.Presence);
                </script>

            </div>
            <div class="col-md-4">
                <label class="form-label">Citt&agrave;</label>
                <input type="text" class="form-control" id="inputCitta" name="inputCitta" maxlength="255"
                    value="{{ auth()->user()->admin->city }}">
                <script type="text/javascript">
                    var citta_ = new LiveValidation('inputCitta', {
                        onlyOnSubmit: true
                    });
                    citta_.add(Validate.Presence);
                    citta_.add(Validate.SoloTesto);
                </script>
            </div>
            <div class="col-md-1">
                <label class="form-label">Provincia</label>
                <input type="text" class="form-control" id="inputProvincia" name="inputProvincia" maxlength="2"
                    value="{{ auth()->user()->admin->province }}">
                <script type="text/javascript">
                    var citta_ = new LiveValidation('inputProvincia', {
                        onlyOnSubmit: true
                    });
                    citta_.add(Validate.Presence);
                    citta_.add(Validate.SoloTesto);
                </script>
            </div>
            <div class="col-md-1">
                <label class="form-label">CAP</label>
                <input type="text" class="form-control" id="inputCAP" name="inputCAP" maxlength="5"
                    value="{{ auth()->user()->admin->postal_code }}">
                <script type="text/javascript">
                    var cap_ = new LiveValidation('inputCAP', {
                        onlyOnSubmit: true
                    });
                    cap_.add(Validate.Presence);
                    cap_.add(Validate.InteriPositivi);
                </script>
            </div>

            <div class="col-12" style="text-align:center">
                <button type="submit" class="btn btn-primary">Modifica Dati</button>
            </div>
        </form>
    </div>
@endsection
