@extends('layouts.layout-bootstrap')

@section('content')
    <script>
        function togglePassword() {
            const x = document.getElementById("password");
            x.type = (x.type === "password") ? "text" : "password";
        }

        function modifica_pass() {
            const x = document.getElementById("password");
            if (x.type === "text") {
                x.type = "password";
            }
        }
    </script>

    <div class="container py-5 h-fill">

        {{-- ALERT --}}
        <div class="mb-3">
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif

            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif
        </div>

        {{-- LOGIN CARD --}}
        <div class="card shadow-sm mx-auto" style="max-width: 420px;">

            <div class="card-body p-4">

                <h3 class="text-center mb-4">Login</h3>

                <form method="POST" action="login" class="row g-3">
                    @csrf

                    <input type="hidden" name="return" value="{{ request('back') ? '1' : '0' }}">

                    {{-- EMAIL --}}
                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" maxlength="255">

                        <script>
                            var email1 = new LiveValidation('email', {
                                onlyOnSubmit: true
                            });
                            email1.add(Validate.Presence);
                            email1.add(Validate.Email);
                        </script>
                    </div>

                    {{-- PASSWORD --}}
                    <div class="col-12">
                        <label class="form-label">Password</label>

                        <input type="password" class="form-control" id="password" name="password" maxlength="255">

                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" onclick="togglePassword()" id="showPass">

                            <label class="form-check-label" for="showPass">
                                Mostra password
                            </label>
                        </div>

                        <script>
                            var pass1_ = new LiveValidation('password', {
                                onlyOnSubmit: true
                            });
                            pass1_.add(Validate.Presence);
                            pass1_.add(Validate.Pass);
                        </script>
                    </div>

                    {{-- RECUPERO --}}
                    <div class="col-12 text-center">
                        <a href="recupera-password">Recupera password</a>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">
                            Accedi
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
