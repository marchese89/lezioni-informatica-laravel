@extends('admin.dashboard-admin')

@section('inner')
@php
use App\Models\ThemeArea;
use App\Models\Matter;
use App\Models\Course;

@endphp
<ul class="nav">
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="dashboard-admin">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="insegnamento">Insegnamento</a>
      </li>
  </ul>
<div class="container"  style="text-align: center;width:35%">
    <h2>Elenco Corsi</h2>
    <br>
</div>
<br>
<div class="container"  style="text-align: center;width:80%">

    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Area Tematica</th>
            <th scope="col">Materia</th>
            <th scope="col">Corso</th>
            <th scope="col">Operazioni</th>
          </tr>
        </thead>
        @php
           $corsi = Course::all();
        @endphp
        <tbody>
            @foreach ($corsi as $item)
          <tr>

            <th scope="row">{{$item->id}}</th>
            <td>
                {{$item->matter->theme_area->name}}
            </td>
            <td>
                {{$item->matter->name}}
            </td>
            <td>{{$item->name}}</td>
            <td>
                <div>
                <button type="submit" class="btn btn-primary" onclick=location.href="modifica-dettagli-corso-{{$item->id}}">Modifica</button>
                </div>
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
</div>
@endsection
