@extends('admin.dashboard-admin')

@section('page-title')
    <div class="container my-4">
        <h2>Elenco Fatture</h2>
    </div>
@endsection

@section('inner')
    <div class="container" style="text-align: center">

        @php
            use App\Models\Invoice;
            use App\Helpers\DateHelper;
            $fatture = Invoice::orderBy('date', 'desc')->get();
        @endphp
        @if (Invoice::count() > 0)
            <table class="table">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Data</th>
                    <th scope="col">File</th>
                </thead>
                <tbody>
                    @foreach ($fatture as $item)
                        <tr>
                            <td>{{ $item->number }}</td>
                            <td>{{ DateHelper::format($item->date) }}</td>
                            <td><button class="btn btn-primary"
                                    onclick=location.href="visualizza-fattura-{{ $item->number }}">Visualizza</button></td>
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
