@extends('admin.dashboard-admin')

@section('inner')
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard-studente">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="corsi">Corsi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="visualizza-corso-{{ request('id_corso') }}">Corso</a>
        </li>
    </ul>
    <div class="container" style="text-align: center;width:100%">
        @php
            use App\Models\Course;
            use App\Models\Exercise;

            $id_corso = request('id_corso');
            $id_esercizio = request('id_esercizio');
            $corso = Course::where('id', '=', $id_corso)->first();
            $esercizio = Exercise::where('id', '=', $id_esercizio)->first();

        @endphp
        <h2>Modifica Esercizio Corso di</h2>
        <h2>"{{ $corso->name }}"</h2>
        <h3>Titolo Esercizio</h3>
        <h3>"{{ $esercizio->title }}"</h3>
        <br>

        <br>
        <h4>Traccia</h4>

        <iframe width="90%" src="/protected_file/{{ $esercizio->trace }}#view=FitH" height="800px">
        </iframe>
        <br>
        <br>
        <h4>Svolgimento</h4>
        <iframe width="90%" src="/protected_file/{{ $esercizio->execution }}#view=FitH" height="800px">
        </iframe>
        <br>
        <br>
    </div>
@endsection
