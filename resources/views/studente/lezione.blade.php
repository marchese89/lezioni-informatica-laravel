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
            use App\Models\Lesson;

            $id_corso = request('id_corso');
            $id_lezione = request('id_lezione');
            $corso = Course::where('id', '=', $id_corso)->first();
            $lezione = Lesson::where('id', '=', $id_lezione)->first();

        @endphp
        <h2>Lezione Corso di</h2>
        <h2>"{{ $corso->name }}"</h2>
        <h3>Titolo Lezione</h3>
        <h3>"{{ $lezione->title }}"</h3>
        <br>

        <br>
        <h4>Presentazione</h4>

        <iframe width="90%" src="/protected_file/{{ $lezione->presentation }}#view=FitH" height="800px">
        </iframe>
        <br>
        <br>
        <h4>Svolgimento</h4>

        <iframe width="90%" src="/protected_file/{{ $lezione->lesson }}#view=FitH" height="800px">
        </iframe>
        <br>
        <br>
    </div>
@endsection
