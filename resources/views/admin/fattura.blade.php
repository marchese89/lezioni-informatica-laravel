@extends('admin.dashboard-admin')

@section('inner')
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard-admin">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="vendite">Vendite</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="admin-ordine-{{ request('id') }}">Ordine</a>
        </li>
    </ul>
    <div class="container">
        @php
            use App\Models\Order;
            $ordine = Order::where('id', '=', request('id'))->first();
        @endphp
        <h4>Fattura</h4>
        <iframe width="90%" src="/protected_file/{{ $ordine->invoice }}#view=FitH" height="800px">
        </iframe>
    </div>
@endsection
