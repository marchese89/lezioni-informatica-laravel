@extends('admin.dashboard-admin')

@section('page-title')
    <div class="container mb-4">
        <h2 class="text-start">Modifica Partita IVA</h2>
    </div>
@endsection

@section('inner')
    <div class="container" style="text-align: center;width:20%">
        <form method="POST" action="mod-piva">
            @csrf

            <div class="col-md-12">
                <input type="text" class="form-control" id="piva" name="piva" minlength="11" maxlength="11"
                    value="{{ auth()->user()->admin->piva }}">
                <script type="text/javascript">
                    var piva_ = new LiveValidation('chiave', {
                        onlyOnSubmit: true
                    });
                    piva_.add(Validate.Presence);
                    piva_.add(Validate.InteriPositivi);
                </script>
            </div>

            <br>
            <div class="col-12" style="text-align:center">
                <button type="submit" class="btn btn-primary">Modifica</button>
            </div>
        </form>

    </div>
@endsection
