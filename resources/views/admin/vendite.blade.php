@extends('admin.dashboard-admin')

@section('inner')
    <script>
        function aggiorna_tabella(anno, mese) {
            fetch(`/cambia_tabella_ordini?anno=${anno}&mese=${mese}`)
                .then(res => res.json())
                .then(data => {
                    let html = '';

                    data.ordini.forEach(o => {
                        html += `
                    <tr>
                        <td>${o.id}</td>
                        <td>${o.studente}</td>
                        <td>${o.data}</td>
                        <td>${o.totale}€</td>
                        <td>
                            <button class="btn btn-primary"
                                onclick="location.href='admin-ordine-${o.id}'">
                                Visualizza Ordine
                            </button>
                        </td>
                    </tr>
                `;
                    });

                    document.getElementById('tabella-body').innerHTML = html;
                    document.getElementById('totale').innerHTML =
                        `<strong>Totale: ${data.totale}€</strong>`;
                });
        }
        window.onload = function() {
            aggiorna_tabella(document.getElementById('floatingSelect1').value,
                document.getElementById('floatingSelect2').value);
        }
    </script>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard-admin">Dashboard</a>
        </li>
    </ul>
    <div class="row g-0 container-fluid" style="text-align: center">
        <h2>Vendite</h2>
        @php
            use App\Models\Order;
            use App\Models\OrderProduct;
            use App\Services\AcquistiService;
            use App\Helpers\DateHelper;
            use App\Models\User;
            use App\Models\Student;
            use Illuminate\Support\Facades\DB;

            $primo_ordine = DB::table('orders')->orderBy(DB::raw('date'), 'desc')->first();
            if ($primo_ordine != null) {
                $data_primo = DateHelper::parse($primo_ordine->date);

                $ordine = DB::table('orders')
                    ->whereMonth('date', $data_primo['mese'])
                    ->whereYear('date', $data_primo['anno'])
                    ->orderBy(DB::raw('date'), 'desc')
                    ->get();

                $years = DB::table('orders')
                    ->select(DB::raw('YEAR(date) as year'))
                    ->groupBy('year')
                    ->orderBy('year', 'asc')
                    ->get();

                $months = DB::table('orders')
                    ->select(DB::raw('MONTH(date) as month'))
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
                        {{ AcquistiService::stringa_mese(intval($data_primo['mese'])) }}
                    </option>
                    @foreach ($months as $item)
                        <option value="{{ $item->month }}">{{ AcquistiService::stringa_mese(intval($item->month)) }}
                        </option>
                    @endforeach
                </select>
                <label for="floatingSelect">Mese</label>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Studente</th>
                        <th>Data</th>
                        <th>Totale</th>
                        <th>Visualizza</th>
                    </tr>
                </thead>

                <tbody id="tabella-body">
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="5" id="totale"></td>
                    </tr>
                </tfoot>
            </table>
        @else
            <br>
            <br>
            <h3>Non ci sono ordini!</h3>
        @endif
    </div>
@endsection
