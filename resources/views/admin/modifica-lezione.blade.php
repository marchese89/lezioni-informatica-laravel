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
        <a class="nav-link active" aria-current="page" href="modifica-dettagli-corso-{{request('id_corso')}}">Corso</a>
      </li>
  </ul>
<div class="container"  style="text-align: center;width:100%">
    @php
        use App\Models\Course;
        use App\Models\Lesson;

        $id_corso = request('id_corso');
        $id_lezione = request('id_lezione');
        $corso = Course::where('id','=',$id_corso)->first();
        $lezione = Lesson::where('id','=',$id_lezione)->first();

    @endphp
    <h2>Modifica Lezione  Corso di</h2>
    <h2>"{{$corso->name}}"</h2>
    <h3>Titolo Lezione</h3>
    <h3>"{{$lezione->title}}"</h3>
    <br>

    <br>
    <h4>Presentazione</h4>

    <iframe
				width="90%"
                src="/protected_file/{{$lezione->presentation}}#view=FitH"
                height="800px">
            </iframe>
            <br>
            <br>
            <div class="container"  style="text-align: center;width:35%">
    <form method="POST" action="re-upload-pres-lez" enctype="multipart/form-data" id="upload" >
        @csrf
        <input type="hidden" name="id" value="{{$id_lezione}}"/>
        <input type="hidden" name="id_corso" value="{{$id_corso}}"/>
        <input type="file" class="form-control" id="file-pres-lez" name="file-pres-lez"/>
        <p>
        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25"
        aria-valuemin="0" aria-valuemax="100" id="progressbar" style="display: none">
            <div class="progress-bar" style="width: 25%" id="percent">25%</div>
          </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary" onclick="upload('upload','file-pres-lez','re-upload-pres-lez',1)">Upload</button>
        </div>

        <br>
        <br>
        </form>
        </div>
        <br>

        <br>
        <h4>Svolgimento</h4>

        <iframe
                    width="90%"
                    src="/protected_file/{{$lezione->lesson}}#view=FitH"
                    height="800px">
                </iframe>
                <br>
                <br>
                <div class="container"  style="text-align: center;width:35%">
        <form method="POST" action="re-upload-lesson" enctype="multipart/form-data" id="upload2" >
            @csrf
            <input type="hidden" name="id" value="{{$id_lezione}}"/>
            <input type="hidden" name="id_corso" value="{{$id_corso}}"/>
            <input type="file" class="form-control" id="file-lesson" name="file-lesson"/>
            <p>
            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25"
            aria-valuemin="0" aria-valuemax="100" id="progressbar2" style="display: none">
                <div class="progress-bar" style="width: 25%" id="percent">25%</div>
              </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary" onclick="upload('upload2','file-lesson','re-upload-lesson',2)">Upload</button>
            </div>

            <br>
            <br>
            </form>
                </div>
            <div class="container"  style="text-align: center;width:35%">
            <form method="POST" action="modifica-lezione" >
                @csrf
                <input type="hidden" name="id_lezione" value="{{$id_lezione}}"/>
                <input type="hidden" name="id_corso" value="{{$id_corso}}"/>
                <div class="col-md-12">
                    <h5>Numero</h5>
                    <input type="text" class="form-control" id="numero" name="numero" value="{{$lezione->number}}"maxlength="5" >
                    <script type="text/javascript">
                        var numero_ = new LiveValidation('numero', {onlyOnSubmit: true});
                        numero_.add(Validate.Presence);
                        numero_.add(Validate.InteriPositivi);
                    </script>
                </div>
                <div class="col-md-12">
                    <h5>Titolo</h5>
                    <input type="text" class="form-control" id="titolo" name="titolo" value="{{$lezione->title}}" maxlength="255" >
                    <script type="text/javascript">
                        var titolo_ = new LiveValidation('titolo', {onlyOnSubmit: true});
                        titolo_.add(Validate.Presence);
                        titolo_.add(Validate.SoloTesto);
                    </script>
                </div>
                <div class="col-md-12">
                    <h5>Prezzo (&euro;)</h5>
                    <input type="text" class="form-control" id="prezzo" name="prezzo" value="{{$lezione->price}}" maxlength="5" style="display: inline">
                    <script type="text/javascript">
                        var prezzo_ = new LiveValidation('prezzo', {onlyOnSubmit: true});
                        prezzo_.add(Validate.Presence);
                        prezzo_.add(Validate.InteriPositivi);
                    </script>
                </div>
                <br>
                <div class="col-12" style="text-align:center">
                    <button type="submit" class="btn btn-primary" >Modifica</button>
                </div>
            </form>
            </div>
            <br>
            <br>
</div>
@endsection
