@extends('admin.dashboard-admin')

@section('inner')
<ul class="nav">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="dashboard-admin">Dashboard</a>
    </li>
</ul>
<div class="container" style="width: 60%;text-align:center">
    <h2>Fattura per prestazioni esterne al sito</h2>
    <form class="row g-3" method="POST" action="crea_fattura_extra" onsubmit="modifica_pass()">
        @csrf
        <div class="col-md-6">
            <label  class="form-label">Nome</label>
            <input type="text" class="form-control" id="inputNome" name="inputNome" maxlength="255">
            <script type="text/javascript">
                var nome_ = new LiveValidation('inputNome', {onlyOnSubmit: true});
                nome_.add(Validate.Presence);
                nome_.add(Validate.SoloTesto);
            </script>
        </div>
        <div class="col-md-6">
            <label class="form-label">Cognome</label>
            <input type="text" class="form-control" id="inputCognome" name="inputCognome" maxlength="255">
            <script type="text/javascript">
                var cognome_ = new LiveValidation('inputCognome', {onlyOnSubmit: true});
                cognome_.add(Validate.Presence);
                cognome_.add(Validate.SoloTesto);
            </script>
        </div>
        <div class="col-md-4">
            <label class="form-label">Indirizzo (via/piazza)</label>
            <input type="text" class="form-control" id="inputIndirizzo" name="inputIndirizzo" maxlength="255">
            <script type="text/javascript">
                var via_ = new LiveValidation('inputIndirizzo', {onlyOnSubmit: true});
                via_.add(Validate.Presence);
                via_.add(Validate.SoloTesto);
            </script>
        </div>
        <div class="col-md-1">
            <label class="form-label">N. Civico</label>
            <input type="text" class="form-control" id="inputNumeroCivico" name="inputNumeroCivico" maxlength="6">
            <script type="text/javascript">
                var n_civico_ = new LiveValidation('inputNumeroCivico', {onlyOnSubmit: true});
                n_civico_.add(Validate.Presence);
            </script>

        </div>
        <div class="col-md-2">
            <label class="form-label">Citt&agrave;</label>
            <input type="text" class="form-control" id="inputCitta" name="inputCitta" maxlength="255">
            <script type="text/javascript">
                var citta_ = new LiveValidation('inputCitta', {onlyOnSubmit: true});
                citta_.add(Validate.Presence);
                citta_.add(Validate.SoloTesto);
            </script>
        </div>
        <div class="col-md-1">
            <label class="form-label">Provincia</label>
            <input type="text" class="form-control" id="inputProvincia" name="inputProvincia" maxlength="2">
            <script type="text/javascript">
                var citta_ = new LiveValidation('inputProvincia', {onlyOnSubmit: true});
                citta_.add(Validate.Presence);
                citta_.add(Validate.SoloTesto);
            </script>
        </div>
        <div class="col-md-1">
            <label class="form-label">CAP</label>
            <input type="text" class="form-control" id="inputCAP" name="inputCAP" maxlength="5">
            <script type="text/javascript">
                var cap_ = new LiveValidation('inputCAP', {onlyOnSubmit: true});
                cap_.add(Validate.Presence);
                cap_.add(Validate.InteriPositivi);
            </script>
        </div>
        <div class="col-md-3">
            <label class="form-label">Codice Fiscale</label>
            <input type="text" class="form-control" id="inputCF" name="inputCF" maxlength="16">
            <script type="text/javascript">
                var cf_ = new LiveValidation('inputCF', {onlyOnSubmit: true});
                cf_.add(Validate.Presence);
                cf_.add(Validate.CodiceFiscale);
            </script>
        </div>
        <div class="col-md-8">
            <label class="form-label">Descrizione</label>
            <input type="text" class="form-control" id="descrizione" name="descrizione" maxlength="255">
            <script type="text/javascript">
                var descrizione_ = new LiveValidation('descrizione', {onlyOnSubmit: true});
                descrizione_.add(Validate.Presence);
                descrizione_.add(Validate.SoloTesto);
            </script>
        </div>
        <div class="col-md-2">
            <label class="form-label">Prezzo</label>
            <input type="text" class="form-control" id="prezzo" name="prezzo" maxlength="12">
            <script type="text/javascript">
                var prezzo_ = new LiveValidation('prezzo', {onlyOnSubmit: true});
                prezzo_.add(Validate.Presence);
                prezzo_.add(Validate.InteriPositivi);
            </script>
        </div>
        <div class="col-md-2">
            <label class="form-label">Qta</label>
            <input type="text" class="form-control" id="qta" name="qta" maxlength="5">
            <script type="text/javascript">
                var qta_ = new LiveValidation('qta', {onlyOnSubmit: true});
                qta_.add(Validate.Presence);
                qta_.add(Validate.InteriPositivi);
            </script>
        </div>
        <div class="col-md-12">
            <label class="form-label">Note</label>
            <input type="text" class="form-control" id="note" name="note" maxlength="255">
            <script type="text/javascript">
                var note_ = new LiveValidation('note', {onlyOnSubmit: true});
                note_.add(Validate.Presence);
                note_.add(Validate.SoloTesto);
            </script>
        </div>
        <div class="col-12" style="text-align:center">
            <button type="submit" class="btn btn-primary" >Crea Fattura</button>
        </div>
    </form>
@endsection
