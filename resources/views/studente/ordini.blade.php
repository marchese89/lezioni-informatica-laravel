@extends('studente.dashboard-studente')

@section('inner')
    <script>
        function aggiorna_tabella(anno, mese) {
            console.log('anno: ' + anno);
            console.log('mese: ' + mese);

            // Crea un oggetto XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Imposta la funzione di gestione dell'evento di completamento della richiesta
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // La richiesta è stata completata con successo
                    _('tabella_ordini').innerHTML = xhr.responseText;
                }
            };

            // Imposta il metodo e l'URL della richiesta
            xhr.open("GET", "cambia_tabella_ordini_studente?anno=" + anno + "&mese=" + mese, true);

            // Invia la richiesta
            xhr.send();
        }
    </script>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard-studente">Dashboard</a>
        </li>
    </ul>
    <div class="row g-0 container-fluid" style="text-align: center">
        <h3>Ordini Effettuati</h3>

        @php
            include app_path('Http/Utility/funzioni.php');
            use App\Http\Utility\Data;
            use App\Models\Order;
            use App\Http\Utility\Acquisti;

            $primo_ordine = Order::where('student_id', '=', auth()->user()->student->id)
                ->orderBy('date', 'desc')
                ->first();
            if ($primo_ordine != null) {
                $data_primo = Data::stampa_data($primo_ordine->date);

                $ordini = DB::table('orders')
                    ->where('student_id', '=', auth()->user()->student->id)
                    ->whereMonth('date', $data_primo['mese'])
                    ->whereYear('date', $data_primo['anno'])
                    ->orderBy(DB::raw('date'), 'desc')
                    ->get();

                $years = DB::table('orders')
                    ->select(DB::raw('YEAR(date) as year'))
                    ->where('student_id', '=', auth()->user()->student->id)
                    ->groupBy('year')
                    ->orderBy('year', 'asc')
                    ->get();

                $months = DB::table('orders')
                    ->select(DB::raw('MONTH(date) as month'))
                    ->where('student_id', '=', auth()->user()->student->id)
                    ->groupBy('month')
                    ->orderBy('month', 'asc')
                    ->get();
            }
        @endphp
        @if ($primo_ordine != null)
            <div class="form-floating" style="display: inline">
                <select class="form-select" id="floatingSelect1" aria-label="Floating label select example"
                    onchange="aggiorna_tabella(_('floatingSelect1').value,_('floatingSelect2').value)">
                    <option selected value="{{ $data_primo['anno'] }}">{{ $data_primo['anno'] }}</option>
                    @foreach ($years as $item)
                        <option value="{{ $item->year }}">{{ $item->year }}</option>
                    @endforeach
                </select>
                <label for="floatingSelect">Anno</label>
            </div>
            <div class="form-floating" style="display: inline">
                <select class="form-select" id="floatingSelect2" aria-label="Floating label select example"
                    onchange="aggiorna_tabella(_('floatingSelect1').value,_('floatingSelect2').value)">
                    <option selected value="{{ $data_primo['mese'] }}">
                        {{ Acquisti::stringa_mese(intval($data_primo['mese'])) }}
                    </option>
                    @foreach ($months as $item)
                        <option value="{{ $item->month }}">{{ Acquisti::stringa_mese(intval($item->month)) }}</option>
                    @endforeach
                </select>
                <label for="floatingSelect">Mese</label>
            </div>
            <table class="table" id="tabella_ordini">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Data</th>
                        <th scope="col">Operazioni</th>
                    </tr>
                </thead>
                <tbody>
                    @php

                    @endphp
                    @foreach ($ordini as $item)
                        <tr>

                            <th scope="row">{{ $item->id }}</th>
                            <td>
                                {{ Data::stampa_stringa_data($item->date) }}
                            </td>
                            <td>
                                <button class="btn btn-primary"
                                    onclick=location.href="ordine-{{ $item->id }}">Visualizza</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
        <h3>Non ci sono ordini!</h3>
        @endif
    @endsection
