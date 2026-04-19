@extends('admin.dashboard-admin')

@section('inner')
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard-admin">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="insegnamento">Insegnamento</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="elenco-corsi">Elenco Corsi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="modifica-dettagli-corso-{{ request('id') }}">Corso</a>
        </li>
    </ul>
    <div class="container" style="text-align: center;width:35%">
        @php
            use App\Models\Course;
            use App\Models\Lesson;

            $id = request('id');
            $corso = Course::where('id', '=', $id)->first();

        @endphp
        <h2>Nuova Lezione Corso di</h2>
        <h2>"{{ $corso->name }}"</h2>
        <br>

        <br>
        <h4>Presentazione</h4>

        <iframe width="90%"
            @if (Session::exists('uploaded_pres_lez')) src="/protected_file/{{ session()->get('uploaded_pres_lez') }}#view=FitH"
                @else
                    src="" @endif
            height="400px">
        </iframe>

        <form method="POST" action="lessons/upload-presentation" enctype="multipart/form-data" id="upload">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}" />
            <input type="file" class="form-control" id="file-pres-lez" name="file-pres-lez" />
            <p>
            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0"
                aria-valuemax="100" id="progressbar" style="display: none">
                <div class="progress-bar" style="width: 25%" id="percent">25%</div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary"
                    onclick="upload('upload','file-pres-lez','lessons/upload-presentation',1)">Upload</button>
            </div>

            <br>
            <br>
        </form>

        <div class="col-12">
            <form method="POST" action="/lessons/upload-presentation">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-primary">
                    Cancella File
                </button>
            </form>
        </div>
        <br>

        <br>
        @if (Session::exists('uploaded_pres_lez'))
            <h4>Svolgimento</h4>

            <iframe width="90%"
                @if (Session::exists('uploaded_lesson')) src="/protected_file/{{ session()->get('uploaded_lesson') }}#view=FitH"
                    @else
                        src="" @endif
                height="400px">
            </iframe>

            <form method="POST" action="lessons/upload-file" enctype="multipart/form-data" id="upload2">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}" />
                <input type="file" class="form-control" id="file-lesson" name="file-lesson" />
                <p>
                <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0"
                    aria-valuemax="100" id="progressbar2" style="display: none">
                    <div class="progress-bar" style="width: 25%" id="percent">25%</div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary"
                        onclick="upload('upload2','file-lesson','lessons/upload-file',2)">Upload</button>
                </div>

                <br>
                <br>
            </form>

            <div class="col-12">
                <form method="POST" action="/lessons/upload-file">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">
                        Cancella File
                    </button>
                </form>
            </div>
        @endif

        @if (Session::exists('uploaded_pres_lez') && Session::exists('uploaded_lesson'))
            <form method="POST" action="carica-lezione">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}" />
                <div class="col-md-12">
                    <h5>Numero</h5>
                    <input type="text" class="form-control" id="numero" name="numero" maxlength="5">
                    <script type="text/javascript">
                        var numero_ = new LiveValidation('numero', {
                            onlyOnSubmit: true
                        });
                        numero_.add(Validate.Presence);
                        numero_.add(Validate.InteriPositivi);
                    </script>
                </div>
                <div class="col-md-12">
                    <h5>Titolo</h5>
                    <input type="text" class="form-control" id="titolo" name="titolo" maxlength="255">
                    <script type="text/javascript">
                        var titolo_ = new LiveValidation('titolo', {
                            onlyOnSubmit: true
                        });
                        titolo_.add(Validate.Presence);
                        titolo_.add(Validate.SoloTesto);
                    </script>
                </div>
                <div class="col-md-12">
                    <h5>Prezzo (&euro;)</h5>
                    <input type="text" class="form-control" id="prezzo" name="prezzo" maxlength="5"
                        style="display: inline">
                    <script type="text/javascript">
                        var prezzo_ = new LiveValidation('prezzo', {
                            onlyOnSubmit: true
                        });
                        prezzo_.add(Validate.Presence);
                        prezzo_.add(Validate.InteriPositivi);
                    </script>
                </div>
                <br>
                <div class="col-12" style="text-align:center">
                    <button type="submit" class="btn btn-primary">Carica</button>
                </div>
            </form>
        @endif
        <br>
        <br>
    </div>
@endsection
