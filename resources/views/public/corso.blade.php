@extends('layouts.layout-bootstrap')

@section('content')
<ul class="nav">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="aree-tematiche">Aree Tematiche</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="materie-{{ request('id_materia') }}">Materie</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="corsi-{{request('id')}}">Corsi</a>
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
    <h2>Corso di</h2>
    <h2>{{$corso->name}}</h2>

    @if(!Auth::check())
    <strong style="color: red">Devi essere autenticato come studente per poter fare aquisti!</strong>
    @endif
</div>
<br>
<div class="container"  style="text-align: center;width:80%">
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
            <td>
                @if($item->price !== 0)
                {{$item->price}} <strong>&euro;</strong>
                @else
                <strong style="color: green">Gratis</strong>
                @endif
            </td>
            <td>
                <button class="btn btn-primary" onclick=location.href="presentazione-lezione-{{$item->id}}-{{$item->course_id}}">Anteprima</button>
                @if(Auth::check() && auth()->user()->role === 'student' && $item->price !== 0)
                    <button type="submit" class="btn btn-primary" onclick=location.href="aggiungi-al-carrello-{{$item->id}}-0">Acquista</button>
                @endif
                @if($item->price === 0)
                <button type="submit" class="btn btn-primary" onclick=location.href="visualizza-lezione-{{$item->id}}-{{$item->course_id}}">Contenuto</button>
                @endif
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
      <br>
    <br>
  <h3>Esercizi</h3>

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
            <td>
                @if($item->price !== 0)
                {{$item->price}} <strong>&euro;</strong>
                @else
                <strong style="color: green">Gratis</strong>
                @endif
            </td>
            <td>
                <button class="btn btn-primary" onclick=location.href="traccia-esercizio-{{$item->id}}-{{request('id')}}">Anteprima</button>
                @if(Auth::check() && auth()->user()->role === 'student' && $item->price !== 0)
                <button type="submit" class="btn btn-primary" onclick=location.href="aggiungi-al-carrello-{{$item->id}}-2">Acquista</button>
                @endif
                @if($item->price === 0)
                <button type="submit" class="btn btn-primary" >Contenuto</button>
                @endif
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
</div>
@endsection
