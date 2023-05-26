@extends('admin.dashboard-admin')

@section('inner')
    @php
        use App\Models\ThemeArea;
        use App\Models\Matter;
        use App\Models\Course;
        use App\Models\Order;
        use App\Models\OrderProduct;
        use App\Models\Exercise;
        use App\Models\Lesson;

    @endphp
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard-studente">Dashboard</a>
        </li>
    </ul>
    <div class="container" style="text-align: center;width:35%">
        <h2>Elenco Corsi</h2>
        <br>
    </div>
    <br>
    <div class="container" style="text-align: center;width:80%">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Area Tematica</th>
                    <th scope="col">Materia</th>
                    <th scope="col">Corso</th>
                    <th scope="col">Operazioni</th>
                </tr>
            </thead>
            @php
                $ordini = Order::where('student_id', '=', request()->user()->id)->get();
                $corsi = [];
            @endphp
            @foreach ($ordini as $ordine)
                @php
                    $id_ordine = $ordine->id;
                    $prodotti = OrderProduct::where('id_ordine', '=', $id_ordine)->get();
                @endphp
                @foreach ($prodotti as $prodotto)
                    @php
                        $id_corso;
                        if ($prodotto->tipo_prodotto == 0) {
                            $lezione = Lesson::where('id', '=', $prodotto->id_prodotto)->first();
                            $id_corso = $lezione->course_id;
                        }
                        if ($prodotto->tipo_prodotto == 2) {
                            $esercizio = Exercise::where('id', '=', $prodotto->id_prodotto)->first();
                            $id_corso = $esercizio->course_id;
                        }

                        $corsi[$id_corso] = true;
                    @endphp
                @endforeach
            @endforeach
            <tbody>
                @foreach ($corsi as $key => $value)
                    @php
                        $item = Course::where('id','=',$key)->first();
                    @endphp
                    <tr>

                        <th scope="row">{{ $item->id }}</th>
                        <td>
                            {{ $item->matter->theme_area->name }}
                        </td>
                        <td>
                            {{ $item->matter->name }}
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <div>
                                <button type="submit" class="btn btn-primary"
                                    onclick=location.href="visualizza-corso-{{ $item->id }}">Visualizza</button>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
