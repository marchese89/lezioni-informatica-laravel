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
<div class="container" style="text-align: center;width:50%">
    <h4>Modifica Email</h4>
    <form method="POST" action="mod-email-admin">
        @csrf
        <div >
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" maxlength="255" value="{{ auth()->user()->email}}">
            <script type="text/javascript">
                var email1 = new LiveValidation('inputEmail', {onlyOnSubmit: true});
                email1.add(Validate.Presence);
                email1.add(Validate.Email);
            </script>
        </div>
        <div >
            @if($errors->any())
                <label style="color: red">{{$errors->first('email')}}</label>
            @endif
        </div>
        <br>
        <div>
        <button type="submit" class="btn btn-primary" >Modifica Email</button>
        </div>
    </form>
    <br>
    <h4>Modifica Password</h4>
    @if (session()->has('success'))
        <div class="alert alert-success">
                {{ session()->get('success') }}
        </div>
    @endif
    <form method="POST" action="mod-pass-admin" onsubmit="modifica_pass()">
        @csrf
        <div >
            <h5>Vecchia Password</h5>
            <input type="password" class="form-control" id="inputPassword_old" name="inputPassword_old" maxlength="255">
            </p>
            <input type="checkbox" onclick="mostraPassword_old()">&nbsp;Mostra Password
            <script type="text/javascript">
                var pass2_ = new LiveValidation('inputPassword_old', {onlyOnSubmit: true});
                pass2_.add(Validate.Presence);
                pass2_.add(Validate.Pass);
            </script>
        </div>
        <div >
            @if($errors->any())
                <label style="color: red">{{$errors->first('pass0')}}</label>
            @endif
        </div>
    <div >
        <h5>Nuova Password</h5>
        <input type="password" class="form-control" id="inputPassword" name="inputPassword" maxlength="255">
        </p>
        <input type="checkbox" onclick="mostraPassword1()">&nbsp;Mostra Password
        <script type="text/javascript">
            var pass1_ = new LiveValidation('inputPassword', {onlyOnSubmit: true});
            pass1_.add(Validate.Presence);
            pass1_.add(Validate.Pass);
        </script>
    </div>
    <div >
        <h5>Conferma Password</h5>
        <input type="password" class="form-control" id="inputPassword2" name="inputPassword2" maxlength="255">
        </p>
        <input type="checkbox" onclick="mostraPassword2()">&nbsp;Mostra Password
        <script type="text/javascript">
            var pass2_ = new LiveValidation('inputPassword2', {onlyOnSubmit: true});
            pass2_.add(Validate.Presence);
            pass2_.add(Validate.Confirmation, {match: 'inputPassword'});
        </script>
    </div>
    <div  style="text-align: center">
        <label>La password deve essere lunga alemno 10
            caratteri,
            <p>contenere almeno una lettera maiuscola e una minuscola,

            <p>un numero, e uno tra i seguenti caratteri speciali: @ # ! ? . ,
                ; :

            <p>non deve inoltre contenere più di due cifre uguali ripetute o
                più di due lettere ripetute

    </label>
    </div>
    <div>
        <button type="submit" class="btn btn-primary" >Modifica Password</button>
        </div>
    </form>

</div>
@endsection
