@extends('layouts.layout-bootstrap')

@section('content')
    <div class="container" style="width: 100%">
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
    </div>
    <div class="container" style="text-align: center;min-height:700px;width:20%">
        <form action="recupera-password" method="POST">
            @csrf
            <div class="col-md-12">
                <br>
                <h4>Email</h4>
                <br>
                <input type="text" class="form-control" id="email" name="email" maxlength="255">
                <script type="text/javascript">
                    var email1 = new LiveValidation('email', {
                        onlyOnSubmit: true
                    });
                    email1.add(Validate.Presence);
                    email1.add(Validate.Email);
                </script>
            </div>
            <br>
            <button class="btn btn-primary">Recupera</button>
        </form>
    </div>
@endsection
