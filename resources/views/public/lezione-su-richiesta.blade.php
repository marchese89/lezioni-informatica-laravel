@extends('layouts.layout-bootstrap')

@section('content')
    <style>
        p {
            font-size: 1.4em;
        }
    </style>
    <div class="container" style="text-align: center;height:700px">
        <br>
        <h3>Richista Svolgimento lezione su Commissione</h3>

        <p>Inserisci un file "traccia" per richiedere lo svolgimento di una lezione su commissione,</p>
        <p>lo svolgimento o la correzione di un esercizio</p>
        <p>Verrà prodotta una risposta che sarà visibile sul tuo profilo studente</p>
        <p>A quel punto potrai vedere il prezzo e decidere se acquistarla</p>
        <p>Sono inclusi nel prezzo eventuali chiarimenti via chat (disponibili dopo l'acquisto)</p>
        <br>
        @if (!Auth::check())
            <font style="color: red">Devi fare il login come studente per accedere a questa funzionalità</font>
            <br>
            <br>
            <button class="btn btn-primary" onclick=location.href="login-1">Login</button>
        @else
            @if (!Session::exists('uploaded_lez_rich'))
                <div class="container" style="width: 30%">
                    <form method="POST" action="add-file-su-richiesta" enctype="multipart/form-data" id="upload">
                        @csrf
                        <input type="file" class="form-control" id="file" name="file" />
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100" id="progressbar" style="display: none">
                            <div class="progress-bar" style="width: 25%" id="percent">25%</div>
                        </div>
                        <br>
                        <br>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary"
                                onclick="upload('upload','file','add-file-su-richiesta',1)">Upload</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="container" style="text-align: center">
                    <h4>File Caricato</h4>
                    <iframe style="height: 400px;width: 400px"
                        src="/protected_file/{{ session('uploaded_lez_rich') }}#view=FitH">
                    </iframe>
                    <br>
                    <br>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" onclick=location.href="elimina-lez-rich">Elimina
                            File</button>
                    </div>

                    <br>
                    <div class="container" style="width: 50%">
                        <form method="POST" action="carica-lez-rich">
                            @csrf
                            <label for=""></label>
                            <input type="text" class="form-control" id="titolo" name="titolo" maxlength="255">
                            <script type="text/javascript">
                                var titolo_ = new LiveValidation('titolo', {
                                    onlyOnSubmit: true
                                });
                                titolo_.add(Validate.Presence);
                                titolo_.add(Validate.SoloTesto);
                            </script>
                            <br>
                            <br>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" >Invia Richiesta</button>
                            </div>
                        </form>
                        <br>
                        <br>
                        <br>
                    </div>

                </div>
            @endif
        @endif
    </div>
@endsection
