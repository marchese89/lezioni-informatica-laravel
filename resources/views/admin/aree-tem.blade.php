@extends('admin.dashboard-admin')

@section('inner')
<ul class="nav">
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="dashboard-admin">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="insegnamento">Insegnamento</a>
      </li>
  </ul>
<div class="container"  style="text-align: center;width:40%">
    <h2>Aree Tematiche</h2>
    <br>

    <form method="POST" action="nuova-a-t" >
        @csrf
        <div>
            <h4>Nuova Area Tematica</h4>
            <input type="text" class="form-control" id="area-t" name="area-t" maxlength="255">
            <script type="text/javascript">
                var area_t = new LiveValidation('area-t', {onlyOnSubmit: true});
                area_t.add(Validate.Presence);
                area_t.add(Validate.SoloTesto);
            </script>
        </div>
        <br>
        <div class="col-12" style="text-align:center">
            <button type="submit" class="btn btn-primary" >Inserisci</button>
        </div>
    </form>

</div>
<br>
<div class="container"  style="text-align: center;width:80%">
  <h3>Aree Tematiche Inserite</h3>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Input</th>
            <th scope="col">Operazioni</th>
          </tr>
        </thead>
        @php
            use App\Models\ThemeArea;
            $aree_t = ThemeArea::all();
        @endphp
        <tbody>
            @foreach ($aree_t as $item)
          <tr>

            <th scope="row">{{$item->id}}</th>
            <td>{{$item->name}}</td>
            <form method="POST" action="modifica-a-t" style="display: inline">

                <input type="hidden" name="id" value="{{$item->id}}"/>
                @csrf
            <td>
                <input type="text" class="form-control" id="nome" name="nome" maxlength="255">
                <script type="text/javascript">
                    var nome_ = new LiveValidation('nome', {onlyOnSubmit: true});
                    nome_.add(Validate.Presence);
                    nome_.add(Validate.SoloTesto);
                </script></td>
            <td>

                <button type="submit" class="btn btn-primary" >Modifica</button>
                </form>
                @if (count($item->matter) == 0)
                <form method="POST" action="elimina-a-t" style="display: inline">
                    <input type="hidden" name="id" value="{{$item->id}}"/>
                    @csrf
                    <button type="submit" class="btn btn-primary" >Elimina</button>
                </form>
                @endif
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
</div>
@endsection
