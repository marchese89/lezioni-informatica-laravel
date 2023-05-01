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
        <div class="col-12" style="text-align: center">
            <h3>Informativa sul trattamento dei dati personali</h3>
            <textarea rows="10" cols="60" disabled style="resize: none">Ai sensi dell'articolo 13 del D.lgs n.196/2003, Le/Vi forniamo le seguenti informazioni:
                1. I dati personali da Lei/Voi forniti o acquisiti nell&apos;ambito della nostra attivit&agrave; saranno oggetto di trattamento improntato ai principi di correttezza, liceit&agrave;, trasparenza e di tutela della Sua/Vostra riservatezza e dei Suoi/Vostri diritti.
                2. Il trattamento di tali dati personali sar&agrave; finalizzato agli adempimenti degli obblighi contrattuali o derivanti da incarico conferito dall&apos;interessato ed in particolare all&apos;invio telematico di eventuali fatture.
                3. Il trattamento potr&agrave; essere effettuato anche con l&apos;ausilio di strumenti elettronici con modalit&agrave; idonee a garantire la sicurezza e riservatezza dei dati.
                4. Il conferimento dei dati &egrave; obbligatorio. L&apos;eventuale rifiuto a fornirci, in tutto o in parte, i Suoi/Vostri dati personali o l&apos;autorizzazione al trattamento implica l&apos;impossibilit&agrave; di iscriversi al sito.
                5. I dati potranno essere comunicati, esclusivamente per le finalit&agrave; sopra indicate, a soggetti determinati al fine di adempiere agli obblighi di cui sopra. Altri soggetti potrebbero venire a conoscenza dei dati in qualit&agrave; di responsabili o incaricati del trattamento o in qualit&agrave; di gestori e manutentori del sito stesso. In nessun caso i dati personali trattati saranno oggetto di diffusione.
                7. Il titolare del trattamento dei dati personali &egrave; Antonio Giovanni Marchese con sede in Via Teodoro Mesimerrio, 1 - 89822 Spadola VV
                Il responsabile del trattamento dei dati personali &egrave; Antonio Giovanni Marchese
                8. Al titolare del trattamento o al responsabile Lei/Voi potr&agrave; rivolgersi per far valere i Suoi diritti, cos&igrave; come previsto dall&apos;articolo 7 del D.lgs n.196/2003, che per Sua/Vostra comodit&agrave; riproduciamo integralmente:
                Art. 7 Diritto di accesso ai dati personali ed altri diritti

                1. L&apos;interessato ha diritto di ottenere la conferma dell&apos;esistenza o meno di dati personali che lo riguardano, anche se non ancora registrati, e la loro comunicazione in forma intelligibile.
                2. L&apos;interessato ha diritto di ottenere l&apos;indicazione:
                a) dell&apos;origine dei dati personali;
                b) delle finalit&agrave; e modalit&agrave; del trattamento;
                c) della logica applicata in caso di trattamento effettuato con l&apos;ausilio di strumenti elettronici;
                d) degli estremi identificativi del titolare, dei responsabili e del rappresentante designato ai sensi dell&apos;articolo 5, comma 2;
                e) dei soggetti o delle categorie di soggetti ai quali i dati personali possono essere comunicati o che possono venirne a conoscenza in qualit&agrave; di rappresentante designato nel territorio dello Stato, di responsabili o incaricati.

                3. L&apos;interessato ha diritto di ottenere:
                a) l&apos;aggiornamento, la rettificazione ovvero, quando vi ha interesse, l&apos;integrazione dei dati;
                b) la cancellazione, la trasformazione in forma anonima o il blocco dei dati trattati in violazione di legge, compresi quelli di cui non &egrave; necessaria la conservazione in relazione agli scopi per i quali i dati sono stati raccolti o successivamente trattati;
                c) l&apos;attestazione che le operazioni di cui alle lettere a) e b) sono state portate a conoscenza, anche per quanto riguarda il loro contenuto, di coloro ai quali i dati sono stati comunicati o diffusi, eccettuato il caso in cui tale adempimento si rivela impossibile o comporta un impiego di mezzi manifestamente sproporzionato rispetto al diritto tutelato.

                4. L&apos;interessato ha diritto di opporsi, in tutto o in parte:
                a) per motivi legittimi al trattamento dei dati personali che lo riguardano, ancorch&eacute; pertinenti allo scopo della raccolta;
                b) al trattamento di dati personali che lo riguardano a fini di invio di materiale pubblicitario o di vendita diretta o per il compimento di ricerche di mercato o di comunicazione commerciali
                                            </textarea>
        </div>
        <div class="col-5">
        </div>
        <div class="col-2" style="text-align: center">
            <div class="form-check" style="align: center">
            <input class="form-check-input" type="checkbox" id="gridCheck" name="gridCheck">
            <label class="form-check-label" for="gridCheck">
                Ho letto l'informativa
            </label>
            <script type="text/javascript">
                var info_ = new LiveValidation('gridCheck', {onlyOnSubmit: true});
                info_.add(Validate.Acceptance);
            </script>
            </div>
        </div>
        <div class="col-5">
        </div>
        <div class="col-12" style="text-align:center">
            <button type="submit" class="btn btn-primary" >Registrati</button>
        </div>
    </form>
</div>
@endsection
