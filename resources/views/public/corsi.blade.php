@extends('layouts.layout-bootstrap')

@section('content')
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="aree-tematiche">Aree Tematiche</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="materie-{{ request('id_materia') }}">Materie</a>
        </li>
    </ul>


    <div id="layoutSidenav_content">
        <main>
            <div class="container" style="width: 80%;text-align:center;height: 800px;">
                <h1>Corsi</h1>
                @php
                    use App\Models\Course;
                    $id_mat = request('id_materia');
                    $corsi = Course::where('matter_id', '=', $id_mat)->get();
                @endphp
                <br>
                <br>
                <br>
                <div id="layoutSidenav_content">
                    <main>
                        <div class="row g-0 container-fluid">
                            @foreach ($corsi as $item)
                                <div class="card" style="width: 16rem;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->name }} </h5>
                                        <a href="corso-{{ $item->id }}" class="btn btn-primary">Vai</a>
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
