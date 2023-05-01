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
          <h5 class="card-title">Modifica Dati personali</h5>
          <a href="mod-dati-pers" class="btn btn-primary">Accedi</a>
        </div>
    </div>
    <div class="card col-md-6" style="width: 30rem;">
        <div class="card-body">
          <h5 class="card-title">Modifica Credenziali</h5>
          <a href="mod-cred" class="btn btn-primary">Accedi</a>
        </div>
    </div>
</div>
@endsection
