@extends('admin.dashboard-admin')

@section('inner')
<ul class="nav">
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="dashboard-admin">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="imp-account">Impostazioni Account</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="mod-dati-pers">Modifica Dati Personali</a>
      </li>
  </ul>
<div class="container"  style="text-align: center;width:60%">
    <h2>Modifica Chiave Privata Stripe</h2>
    <br>

    <form method="POST" action="mod-chiave-stripe" >
        @csrf
        <div class="col-md-12">
            <label class="form-label">Chiave</label>
            <input type="text" class="form-control" id="chiave" name="chiave" maxlength="255" value="{{auth()->user()->admin->stripe_private_key}}">
            <script type="text/javascript">
                var via_ = new LiveValidation('chiave', {onlyOnSubmit: true});
                via_.add(Validate.Presence);
            </script>
        </div>
        <br>
        <div class="col-12" style="text-align:center">
            <button type="submit" class="btn btn-primary" >Modifica</button>
        </div>
    </form>

</div>
@endsection
