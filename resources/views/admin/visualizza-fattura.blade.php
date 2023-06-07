@extends('admin.dashboard-admin')

@section('inner')
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard-admin">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="fatture">Fatture</a>
        </li>
    </ul>
    <div class="container">
        @php
            use App\Models\InvoiceSheet;
            $fattura = InvoiceSheet::where('id', '=', request('id'))->first();
        @endphp
        <h4>Fattura</h4>
        <iframe width="90%" src="/protected_file/{{ $fattura->file }}#view=FitH" height="800px">
        </iframe>
    </div>
@endsection
