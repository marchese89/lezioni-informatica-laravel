@extends('studente.dashboard-studente')

@section('inner')
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard-studente">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="corsi">Corsi</a>
        </li>
    </ul>
    <div class="container" style="text-align: center;width:35%">
        @php
            include app_path('Http/Utility/funzioni.php');
            use App\Models\Course;
            use App\Models\Lesson;
            use App\Models\Exercise;
            use App\Http\Utility\Acquisti;

            $corso = Course::where('id', '=', request('id'))->first();

        @endphp
        <h2>Visualizza Corso</h2>
        <h2>{{ $corso->name }}</h2>
        <br>

    </div>
    <br>
    <div class="container" style="text-align: center;width:80%">
        <h3>Lezioni</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Numero</th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Operazioni</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $lezioni = Lesson::all();
                @endphp
                @foreach ($lezioni as $item)
                    @if (Acquisti::prodotto_acquistato(request()->user()->student->id, $item->id, 0))
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td>
                                {{ $item->number }}
                            </td>
                            <td>
                                {{ $item->title }}
                            </td>
                            <td>
                                <button class="btn btn-primary"
                                    onclick=location.href="lezione-{{ request('id') }}-{{ $item->id }}">Visualizza</button>
                            </td>

                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <br>
        <br>
        <h3>Esercizi</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Operazioni</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $esercizi = Exercise::all();
                @endphp
                @foreach ($esercizi as $item)
                    @if (Acquisti::prodotto_acquistato(request()->user()->student->id, $item->id, 2))
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td>

                            </td>
                            <td>
                                {{ $item->title }}
                            </td>
                            <td>
                                <button class="btn btn-primary"
                                    onclick=location.href="esercizio-{{ request('id') }}-{{ $item->id }}">Visualizza</button>
                            </td>

                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
