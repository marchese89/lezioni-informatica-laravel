@extends('layouts.layout-bootstrap')

@section('content')
<div class="container" style="width: 80%;text-align:center;height: 800px;">
    <h1>Aree Tematiche</h1>
@php
    use App\Models\ThemeArea;

    $aree_t = ThemeArea::all();
@endphp
<br>
<br>
<div id="layoutSidenav_content">
    <main>
        <div class="row g-0 container-fluid" >
@foreach ($aree_t as $item)
<div class="card" style="width: 16rem;">
    <div class="card-body">
      <h5 class="card-title">{{$item->name}} </h5>
      <a href="materie-{{$item->id}}" class="btn btn-primary">Vai</a>
    </div>
</div>
@endforeach
        </div>
    </main>
</div>
</div>
<br>
<br>
@endsection
