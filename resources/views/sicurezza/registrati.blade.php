@extends('layouts.layout-bootstrap')

@section('content')
<div class="container" style="width: 62%">
    <br>
    <form class="row g-3" method="POST" action="registrati" onsubmit="modifica_pass()">
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
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" maxlength="255">
            <script type="text/javascript">
                var email1 = new LiveValidation('inputEmail', {onlyOnSubmit: true});
                email1.add(Validate.Presence);
                email1.add(Validate.Email);
            </script>
        </div>
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Conferma Email</label>
            <input type="email" class="form-control" id="inputEmail2" name="inputEmail2" maxlength="255">
            <script type="text/javascript">
                var email2 = new LiveValidation('inputEmail2', {onlyOnSubmit: true});
                email2.add(Validate.Presence);
                email2.add(Validate.Email);
                email2.add(Validate.Confirmation, {match: 'inputEmail'});
            </script>
        </div>
        <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword" name="inputPassword" maxlength="255">
            </p>
            <input type="checkbox" onclick="mostraPassword1()">&nbsp;Mostra Password
            <script type="text/javascript">
                var pass1_ = new LiveValidation('inputPassword', {onlyOnSubmit: true});
                pass1_.add(Validate.Presence);
                pass1_.add(Validate.Pass);
            </script>
        </div>
        <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Conferma Password</label>
            <input type="password" class="form-control" id="inputPassword2" name="inputPassword2" maxlength="255">
            </p>
            <input type="checkbox" onclick="mostraPassword2()">&nbsp;Mostra Password
            <script type="text/javascript">
                var pass2_ = new LiveValidation('inputPassword2', {onlyOnSubmit: true});
                pass2_.add(Validate.Presence);
                pass2_.add(Validate.Confirmation, {match: 'inputPassword'});
            </script>
        </div>
        <div class="col-12" style="text-align: center">
            <label>La password deve essere lunga alemno 10
                caratteri,
                <p>contenere almeno una lettera maiuscola e una minuscola,

                <p>un numero, e uno tra i seguenti caratteri speciali: @ # ! ? . ,
                    ; :

                <p>non deve inoltre contenere più di due cifre uguali ripetute o
                    più di due lettere ripetute

        </label>
        </div>
        <div class="col-12" style="text-align:center">
            <button type="submit" class="btn btn-primary" >Registrati</button>
        </div>
    </form>
</div>
@endsection
