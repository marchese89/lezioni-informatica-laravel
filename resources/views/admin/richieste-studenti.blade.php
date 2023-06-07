@extends('admin.dashboard-admin')

@section('inner')
    <style>
        .cerchio {
            width: 40px;
            height: 40px;
            background-color: red;
            border-radius: 50%;
            display: inline-block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    @php
        include app_path('Http/Utility/funzioni.php');
        use App\Http\Utility\Data;
        use App\Models\LessonOnRequest;
    @endphp
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard-admin">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="studenti">Studenti</a>
        </li>
    </ul>
    <div class="row g-0 container-fluid" style="text-align: center">
        <h2>Richieste Studenti</h2>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Data</th>
                    <th scope="col">Evasa</th>
                    <th scope="col">Operazioni</th>
                </tr>
            </thead>
            @php
                $lezioni_su_richiesta = LessonOnRequest::orderBy('date', 'asc')->get();
            @endphp
            <tbody>
                @foreach ($lezioni_su_richiesta as $item)
                    <tr>

                        <th scope="row">{{ $item->id }}</th>
                        <td>
                            {{ $item->title }}
                        </td>
                        <td>
                            {{ Data::stampa_stringa_data($item->date) }}
                        </td>
                        <td>
                            @php
                                $r = $item->escaped;
                                if ($r == 0) {
                                    echo '<div class="cerchio" style="background-color: red;"></div>';
                                } else {
                                    echo '<div class="cerchio" style="background-color: green;"></div>';
                                }
                            @endphp
                        </td>
                        <td>
                            <div>
                                <button type="submit" class="btn btn-primary"
                                    onclick=location.href="visualizza-richiesta-{{ $item->id }}">Visualizza</button>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
