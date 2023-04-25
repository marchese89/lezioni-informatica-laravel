@extends('admin.dashboard-admin')

@section('inner')
<ul class="nav">
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="dashboard-admin">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="imp-account">Impostazioni Account</a>
      </li>
  </ul>
<div class="row g-0 container-fluid" >
    <div class="card col-md-6" style="width: 30rem;">
        <div class="card-body">
          <h5 class="card-title">Modifica Foto</h5>
          <a href="mod-foto-admin" class="btn btn-primary">Accedi</a>
        </div>
    </div>
    <div class="card col-md-6" style="width: 30rem;">
        <div class="card-body">
          <h5 class="card-title">Modifica Indirizzo</h5>
          <a href="mod-indirizzo-admin" class="btn btn-primary">Accedi</a>
        </div>
    </div>
    <div class="card col-md-6" style="width: 30rem;">
        <div class="card-body">
          <h5 class="card-title">Modifica Chiave Privata Stripe</h5>
          <a href="mod-chiave-priv-stripe" class="btn btn-primary">Accedi</a>
        </div>
    </div>
    <div class="card col-md-6" style="width: 30rem;">
        <div class="card-body">
          <h5 class="card-title">Modifica Certificati</h5>
          <a href="mod-certif" class="btn btn-primary">Accedi</a>
        </div>
    </div>
</div>
@endsection
