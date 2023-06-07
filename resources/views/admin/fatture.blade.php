@extends('admin.dashboard-admin')

@section('inner')
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard-admin">Dashboard</a>
        </li>
    </ul>
    <div class="container" style="text-align: center">

        @php
            include app_path('Http/Utility/funzioni.php');
            use App\Models\InvoiceSheet;
            use App\Http\Utility\Data;
            $fatture = InvoiceSheet::orderBy('date', 'desc')->get();
        @endphp
        @if (InvoiceSheet::count() > 0)
            <br>
            <h3>Elenco Fatture</h3>
            <table class="table">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Data</th>
                    <th scope="col">File</th>
                </thead>
                <tbody>
                    @foreach ($fatture as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{Data::stampa_stringa_data($item->date)}}</td>
                        <td><button class="btn btn-primary" onclick=location.href="visualizza-fattura-{{$item->id}}">Visualizza</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <br>
            <h3>Non ci sono fatture!</h3>
        @endif

    </div>
@endsection
