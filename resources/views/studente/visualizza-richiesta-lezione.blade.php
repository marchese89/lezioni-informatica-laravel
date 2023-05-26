@extends('studente.dashboard-studente')

@section('inner')
    @php
        use App\Models\LessonOnRequest;
        $richiesta = LessonOnRequest::where('id', '=', request('id'))->first();
    @endphp
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard-studente">Dashboard</a>
        </li>
        @if ($richiesta->paid == 0)
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="richieste-dirette">Richieste Dirette</a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="richieste-dirette-acquistate">Richieste Dirette</a>
            </li>
        @endif
    </ul>
    <div class="container" style="text-align: center">
        <h3>Richiesta Lezione: </h3>
        <h3 style="color: blue">{{ $richiesta->title }}</h3>
        <h4>Traccia</h4>

        <iframe width="90%" src="/protected_file/{{ $richiesta->trace }}#view=FitH" height="800px">
        </iframe>
        <br>
        <br>
        @if ($richiesta->price != null && $richiesta->price != 0 && $richiesta->paid == 0)
            <div class="col-md-12">
                <h5>Prezzo</h5>
                <label>{{ $richiesta->price }} &nbsp;<strong>&euro;</strong></label>
            </div>
            <br>
            <div class="col-12" style="text-align:center">
                <button type="submit" class="btn btn-primary"
                    onclick=location.href="aggiungi-al-carrello-{{ $richiesta->id }}-5">Acquista</button>
            </div>
        @endif
        @if ($richiesta->paid == 1)
            <br>
            <br>
            <h4>Soluzione</h4>
            <iframe width="90%" src="/protected_file/{{ $richiesta->execution }}#view=FitH" height="800px">
            </iframe>
            <br>
            <br>
        @endif
        <br>
        <br>
    </div>
    </div>
@endsection
