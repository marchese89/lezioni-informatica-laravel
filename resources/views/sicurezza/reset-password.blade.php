@extends('layouts.layout-bootstrap')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container" style="text-align: center;min-height:700px;width:20%">
        <br>
        <br>
        <h2>Reset Password</h2>
        <form method="POST" action="/reset-password">
            @csrf
            <input class="form-control" type="hidden" name="token" value="{{ $token }}">
            <br>
            <br>

            <input class="form-control" type="email" name="email" placeholder="Email">
            <br>
            <br>

            <input class="form-control" type="password" name="password" placeholder="Nuova password">
            <br>
            <br>

            <input class="form-control" type="password" name="password_confirmation" placeholder="Conferma password">
            <br>
            <br>

            <button type="submit" class="btn btn-primary">Cambia password</button>
        </form>
    </div>
@endsection
