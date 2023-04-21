@extends('admin.dashboard-admin')

@section('inner')
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
          <a href="#" class="btn btn-primary">Accedi</a>
        </div>
    </div>
    <div class="card col-md-6" style="width: 30rem;">
        <div class="card-body">
          <h5 class="card-title">Modifica Chiave Privata Stripe</h5>
          <a href="#" class="btn btn-primary">Accedi</a>
        </div>
    </div>
    <div class="card col-md-6" style="width: 30rem;">
        <div class="card-body">
          <h5 class="card-title">Modifica Certificati</h5>
          <a href="#" class="btn btn-primary">Accedi</a>
        </div>
    </div>
</div>
@endsection
