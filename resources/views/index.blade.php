@extends('layouts.layout-bootstrap')

@section('content')
<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" style="height:250px;">
  <div class="carousel-inner" style="height:250px">
    <div class="carousel-item active">
      <img src="/files/peakpx.jpg" class="d-block w-100" alt="..." style="height:250px;">
    </div>
    <div class="carousel-item">
      <img src="/files/peakpx.jpg" class="d-block w-100" alt="..." style="height:250px;">
    </div>
    <div class="carousel-item">
      <img src="/files/peakpx.jpg" class="d-block w-100" alt="..." style="height:250px;">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
    <table style="width: 100%; font-size: 28pt;font-family: cursive;text-align:center;" id="pannello_controllo">
        <tr style="height: 100px;"><th><b>Sei uno <font color="green">studente</font>?</b></th></tr>
        <tr style="height: 100px"><th><b>Hai bisogno di aiuto con lo studio</b></th></tr>
        <tr style="height: 100px"><th><b>dell'<font color="green">informatica</font>?</b></th></tr>
        <tr style="height: 100px"><th><b>Acquista i <font color="green">corsi</font> o le <font color="green">lezioni singole</font>,</b></th></tr>
        <tr style="height: 100px"><th><b>acquista gli <font color="green">esercizi svolti,</font></b></th></tr>
        <tr style="height: 100px"><th><b>manda i tuoi <font color="green">esercizi svolti</font> da correggere,</b></th></tr>
        <tr style="height: 100px"><th><b>manda le <font color="green">tracce</font> degli esercizi da svolgere.</b></th></tr>
        <tr style="height: 100px"><th><b>Oppure se preferisci si possono fare</b></th></tr>
        <tr style="height: 100px"><th><b>le classiche <font color="green">lezioni private</font></b></th></tr>
        <tr style="height: 100px"><th><b>Sono sono a tua disposizione,</b></th></tr>
        <tr style="height: 100px"><th><b><font color="green">sempre</font> vicino alle tue esigenze!</b></th></tr>
    </table>
@endsection

