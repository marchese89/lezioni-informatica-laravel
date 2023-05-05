@extends('admin.dashboard-admin')

@section('inner')
<ul class="nav">
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="../dashboard-admin">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="../insegnamento">Insegnamento</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="../elenco-corsi">Elenco Corsi</a>
      </li>
  </ul>
<div class="container"  style="text-align: center;width:35%">
    @php
        use App\Models\ThemeArea;
            use App\Models\Matter;
            use App\Models\Course;
            use App\Models\Lesson;
            use App\Models\Execise;

        $corso = Course::where('id','=',request('id'))->first();

    @endphp
    <h2>Modifica Corso</h2>
    <h2>{{$corso->name}}</h2>
    <br>
    @php
        $materie = Matter::all();
    @endphp

</div>
<br>
<div class="container"  style="text-align: center;width:80%">
    <div>
        <button type="submit" class="btn btn-primary"  onclick=location.href="nuova-lezione-{{request('id')}}">Nuova Lezione</button>
    </div>
  <h3>Lezioni</h3>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Numero</th>
            <th scope="col">Titolo</th>
            <th scope="col">Prezzo</th>
            <th scope="col">Operazioni</th>
          </tr>
        </thead>
        @php
           $lezioni = Lesson::all();
        @endphp
        <tbody>
            @foreach ($lezioni as $item)
          <tr>

            <th scope="row">{{$item->id}}</th>
            <td>
                {{$item->number}}
            </td>
            <td>
                {{$item->title}}
            </td>
            <td>{{$item->price}} &euro;</td>
            <form method="POST" action="modifica-corso" style="display: inline">

                <input type="hidden" name="id" value="{{$item->id}}"/>
                @csrf
            <td>

                <button type="submit" class="btn btn-primary" >Modifica</button>
                </form>
                @if (/*count($item->matter) == 0*/true)
                <form method="POST" action="elimina-corso" style="display: inline">
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
