@extends('admin.dashboard-admin')

@section('inner')
<ul class="nav">
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="dashboard-admin">Dashboard</a>
    </li>
  </ul>
<div class="row g-0 container-fluid" >
    <div class="card col-md-6" style="width: 30rem;">
        <div class="card-body">
          <h5 class="card-title">Richieste Studenti</h5>
          <a href="richieste-studenti" class="btn btn-primary">Accedi</a>
        </div>
    </div>
    <div class="card col-md-6" style="width: 30rem;">
        <div class="card-body">
          <h5 class="card-title">Chat Studenti</h5>
          <a href="#" class="btn btn-primary">Accedi</a>
        </div>
    </div>
</div>
@endsection
