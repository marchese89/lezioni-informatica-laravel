@extends('admin.dashboard-admin')

@section('inner')
<div class="container" style="width: 30%; text-align: center;height:800px">
    <h4>Modifica Foto</h4>

<img alt="Nessuna Foto Caricata" src="{{ auth()->user()->admin->photo }}" width="300" height="300"/>
<p>

<form method="POST" action="upload-foto-admin" enctype="multipart/form-data" id="upload">
@csrf
<input type="file" class="form-control" id="file" name="file"/>
<p>
<div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25"
aria-valuemin="0" aria-valuemax="100" id="progressbar" style="display: none">
    <div class="progress-bar" style="width: 25%" id="percent">25%</div>
  </div>

<div class="col-12">
    <button type="submit" class="btn btn-primary" onclick="upload('upload','file','upload-foto-admin')">Upload</button>
</div>


</form>

</div>
@endsection
