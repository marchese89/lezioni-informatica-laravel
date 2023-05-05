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
    <h2>Modifica Certificati</h2>
    <button class="btn btn-primary" onclick=location.href="aggiungi-certif">Aggiungi Certificato</button>
    <br>
    <br>
    <br>
    @php
    $certificates = DB::table('certificates')->select('*')->get();
    @endphp
    @foreach ($certificates as $item)
        <div class="container" style="text-align: center;width:60%">
            <h4>Nome Certficato</h4>
            <form method="POST" action="mod-nome-cert-admin">
                @csrf
                <input  type="hidden" name="id" value="{{$item->id}}"/>
                <input  class="form-control col-4" = maxlength="255" type="text" name="nome_{{$item->id}}" value="{{$item->nome}}"></input>
                <script type="text/javascript">
                    var nome_ = new LiveValidation('nome_'+{{$item->id}}, {onlyOnSubmit: true});
                    nome_.add(Validate.Presence);
                    nome_.add(Validate.SoloTesto);
                </script>
                <br>
                <button type="submit" class="btn btn-primary">Modifica</button>
            </form>
            <br>
            <br>
            <h4>Certficato</h4>
            <br>
            <iframe
				width="90%"
                @if ($item->percorso_file != null)
                src="{{$item->percorso_file}}#view=FitH"
                @endif
                height="400px">
            </iframe>
            <br>
            <br>
            <br>
            <form method="POST" action="mod-foto-cert-admin" enctype="multipart/form-data" id="upload">
                @csrf
                <input type="file" class="form-control" id="file_{{$item->id}}" name="file_{{$item->id}}"/>
                <input  type="hidden" name="id" value="{{$item->id}}"/>
                <p>
                <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25"
                aria-valuemin="0" aria-valuemax="100" id="progressbar" style="display: none">
                    <div class="progress-bar" style="width: 25%" id="percent">25%</div>
                  </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" onclick="upload('upload','file_{{$item->id}}','mod-foto-cert-admin',1)">Upload</button>
                </div>
                </form>
                <br>
                <br>
                <form method="POST" action="elimina_certificato">
                    @csrf
                    <input type="hidden" name="id" value="{{ $item->id }}" />
                    <button type="submit"  class="btn btn-primary" >Elimina Certficato</button>
                </form>
                <br>
                <br>
        </div>
    @endforeach
</div>
@endsection
