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
            use App\Models\Exercise;

        $corso = Course::where('id','=',request('id'))->first();

    @endphp
    <h2>Modifica Corso</h2>
    <h2>{{$corso->name}}</h2>
    <br>

</div>
<br>
<div class="container"  style="text-align: center;width:80%">
    <div>
        <button type="submit" class="btn btn-primary"  onclick=location.href="nuova-lezione-{{request('id')}}">Nuova Lezione</button>
    </div>
    <br>
    <br>
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
            <td>{{$item->price}} <strong>&euro;</strong></td>
            <td>
                <button class="btn btn-primary" onclick=location.href="modifica-lezione-{{request('id')}}-{{$item->id}}">Modifica</button>
                <form method="POST" action="elimina-lezione" style="display: inline">
                    @csrf
                    <input type="hidden" name="id_corso" value="{{request('id')}}"/>
                    <input type="hidden" name="id" value="{{$item->id}}"/>
                    <button type="submit" class="btn btn-primary" >Elimina</button>
                </form>
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
      <br>
    <br>
  <h3>Esercizi</h3>
  <div>
    <button type="submit" class="btn btn-primary"  onclick=location.href="nuovo-esercizio-{{request('id')}}">Nuovo Esercizio</button>
</div>
<br>
<br>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col"></th>
            <th scope="col">Titolo</th>
            <th scope="col">Prezzo</th>
            <th scope="col">Operazioni</th>
          </tr>
        </thead>
        @php
           $esercizi = Exercise::all();
        @endphp
        <tbody>
            @foreach ($esercizi as $item)
          <tr>

            <th scope="row">{{$item->id}}</th>
            <td>

            </td>
            <td>
                {{$item->title}}
            </td>
            <td>{{$item->price}} <strong>&euro;</strong></td>
            <td>
                <button class="btn btn-primary" onclick=location.href="modifica-esercizio-{{request('id')}}-{{$item->id}}">Modifica</button>
                <form method="POST" action="elimina-esercizio" style="display: inline">
                    @csrf
                    <input type="hidden" name="id_corso" value="{{request('id')}}"/>
                    <input type="hidden" name="id" value="{{$item->id}}"/>
                    <button type="submit" class="btn btn-primary" >Elimina</button>
                </form>
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
</div>
@endsection
