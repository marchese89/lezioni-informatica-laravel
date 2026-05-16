@extends('admin.dashboard-admin')

@section('page-title')
    <div class="container">
        <h2>Fattura</h2>
    </div>
@endsection

@section('inner')
    <div class="container">
        @php
            use App\Models\Invoice;
            $fattura = Invoice::where('number', '=', request('id'))->first();
        @endphp
        <iframe width="90%" src="/protected_file/{{ $fattura->path }}#view=FitH" height="800px">
        </iframe>
    </div>
@endsection
