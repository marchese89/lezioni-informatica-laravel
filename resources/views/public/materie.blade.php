@extends('layouts.layout-bootstrap')

@section('content')
<ul class="nav">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="aree-tematiche">Aree Tematiche</a>
    </li>

</ul>

<div id="layoutSidenav_content">
    <main>
<div class="container" style="width: 80%;text-align:center;height: 800px;">
    <h1>Materie</h1>
@php
    use App\Models\Matter;
    $id_at = request('id_at');
    $materie = Matter::where('theme_area_id','=', $id_at)->get();
@endphp
<br>
<br>
<br>
<div id="layoutSidenav_content">
    <main>
        <div class="row g-0 container-fluid" >
@foreach ($materie as $item)
<div class="card" style="width: 16rem;">
    <div class="card-body">
      <h5 class="card-title">{{$item->name}} </h5>
      <a href="corsi-{{$item->id}}" class="btn btn-primary">Vai</a>
    </div>
</div>
@endforeach
</main>
    </div>
</div>
<br>
<br>

</div>
@endsection
