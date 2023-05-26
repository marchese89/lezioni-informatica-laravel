@extends('layouts.layout-bootstrap')

@section('content')
    <script>
        function mostraPassword1() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function modifica_pass() {
            var x = document.getElementById("password");
            if (x.type === "text") {
                x.type = "password";
            }

        }
    </script>
    <div class="container" style="width: 15%; text-align: center;height:800px">
        <br>
        <h2>Login</h2>
        <form class="row g-3" method="POST" action="login">
            @csrf
            <input type="hidden" name="return" value="<?php if(request('back') != null){echo '1';}else{echo '0';} ?>">
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" maxlength="255">
                <script type="text/javascript">
                    var email1 = new LiveValidation('email', {
                        onlyOnSubmit: true
                    });
                    email1.add(Validate.Presence);
                    email1.add(Validate.Email);
                </script>
            </div>
            <div class="col-md-12">
                <label for="inputPassword4" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" maxlength="255">
                </p>
                <input type="checkbox" onclick="mostraPassword1()">&nbsp;Mostra Password
                <script type="text/javascript">
                    var pass1_ = new LiveValidation('password', {
                        onlyOnSubmit: true
                    });
                    pass1_.add(Validate.Presence);
                    pass1_.add(Validate.Pass);
                </script>
            </div>
            <div class="col-md-12">
                @if ($errors->any())
                    <label style="color: red">{{ $errors->first() }}</label>
                @endif
            </div>
            <div class="col-12" style="text-align:center">
                <button type="submit" class="btn btn-primary">Accedi</button>
            </div>
        </form>
    </div>
@endsection
