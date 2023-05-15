@extends('layouts.layout-bootstrap')

@section('content')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="pagamenti/checkout.js?ts=<?= time() ?>&quot" defer></script>
    <div class="container" style="text-align: center;width:35%">
        <h2>Acquista</h2>
    </div>
    <br>
    <div class="container" style="text-align: center;width:80%; height:800px">

        @php
            $carrello = session()->get('carrello');
            $tot = $carrello->getTotale();
        @endphp
        <h3>Paga <strong><?php echo $tot; ?>&euro;</strong> in modo Sicuro tramite Stripe</h3>
        <br>
        <form id="payment-form">
        <div id="payment-element" style="width: 600px;margin-left: auto;margin-right: auto;">
            <!--Stripe.js injects the Payment Element-->
          </div>
        <br>
        <div>
            <button id="submit" class="btn btn-primary">
                <div class="spinner hidden" id="spinner"></div>
                <span id="button-text">Paga Adesso</span>
              </button>
              <div id="payment-message" class="hidden"></div>
              <br>
              <br>

        </div>
        </form>
        <button class="btn btn-primary" onclick=location.href="visualizza-carrello">Indietro</button>
    </div>
@endsection
