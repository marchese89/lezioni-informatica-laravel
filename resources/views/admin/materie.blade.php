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
<div class="container"  style="text-align: center;width:35%">
    <h2>Materie</h2>
    <br>

    <form method="POST" action="nuova-mat" >
        @csrf
        <div>
            <h4>Nuova Materia</h4>
            @php
            use App\Models\ThemeArea;
           //$aree_t = DB::table('theme_areas')->get();
           $aree_t = ThemeArea::all();
        @endphp
        <h5>Area Tematica</h5>
            <select class="form-select" name="area-t">
                @foreach ($aree_t as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
              </select>
              <br>
              <h5>Nome</h5>
            <input type="text" class="form-control" id="materia" name="materia" maxlength="255">
            <script type="text/javascript">
                var area_t = new LiveValidation('materia', {onlyOnSubmit: true});
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
  <h3>Materie Inserite</h3>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Area Tematica</th>
            <th scope="col">Nome</th>
            <th scope="col">Input</th>
            <th scope="col">Operazioni</th>
          </tr>
        </thead>
        @php
            use App\Models\Matter;
           $materie = Matter::all();
        @endphp
        <tbody>
            @foreach ($materie as $item)
          <tr>

            <th scope="row">{{$item->id}}</th>
            <td>
                @php
                $theme_area = ThemeArea::where('id','=', $item->theme_area_id)->first();
                @endphp
                {{$theme_area->name}}
            </td>
            <td>{{$item->name}}</td>
            <form method="POST" action="modifica-mat" style="display: inline">

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
                @if (count($item->courses) == 0)
                <form method="POST" action="elimina-mat" style="display: inline">
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
