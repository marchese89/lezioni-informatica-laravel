@extends('layouts.layout-bootstrap')

@section('content')
    <style>
        p {
            font-size: 1.4em;
        }

        p a {
            font-size: 1.4em;
        }

        .stars2 a{
            opacity: 20%;
            cursor:  default;
        }
    </style>
    @php
        use App\Models\User;
        use App\Models\Student;
        use App\Models\Admin;
        use App\Models\Feedback;

        $feedbacks = Feedback::all();

        $user = User::where('role', '=', 'admin')->first();
        $admin = $user->admin;
    @endphp
    <div class="container" style="text-align: center">
        <br>
        <br>
        <img alt="Foto" src=".{{ $admin->photo }}" height="400" style="border-radius: 10px 10px 10px 10px" />
        <p>Laureato Magistrale in Ingegeria Informatica (110/110)</p>
        <p>Offre supporto allo studio:</p>
        <p>soluzione esercizi</p>
        <p>lezioni private online</p>
        <p>Tariffe:</p>
        <p>15&euro; l'ora per le scuole superiori</p>
        <p>20&euro; l'ora per l'univesit&agrave;</p>
        <p><strong>Contatti:</strong></p>
        <p>
            Email: <a href="mailto:marchese89@hotmail.com">marchese89@hotmail.com</a>
        </p>
        <p>
            Telefono: <a href="tel:+393272991334">+393272991334</a>
        </p>
        <p>
            <img src="https://cdn-icons-png.flaticon.com/512/124/124034.png?w=360" width="30px"
                style="border-radius: 5px 5px 5px 5px;">
            <a href="https://api.whatsapp.com/send?phone=3272991334" target="_blank">Invia
                messaggio su WhatsApp</a>
        </p>

        @if ($feedbacks != null && $feedbacks->count() > 0)
            <h2>Punteggio Feedback</h2>
            @php
                $count = $feedbacks->count();
                $somma = 0.0;
                foreach ($feedbacks as $feed) {
                    $somma += $feed->punteggio;
                }
                $f = number_format($somma / $count, 2, ',', '.');
            @endphp
            <strong style="font-size: 20pt">{{ $f }}/5</strong>
            <div class="stars2" id="stars">
                <a <?php if($somma / $count > 0.5){?> style="opacity: 100%;" <?php }?>
                    >⭐</a>
                <a <?php if($somma / $count > 1.5){?> style="opacity: 100%;" <?php }?>
                    >⭐</a>
                <a <?php if($somma / $count > 2.5){?> style="opacity: 100%;" <?php }?>
                    >⭐</a>
                <a <?php if($somma / $count > 3.5){?> style="opacity: 100%;" <?php }?>
                    >⭐</a>
                <a <?php if($somma / $count > 4.5){?> style="opacity: 100%;" <?php }?>
                    >⭐</a>
            </div>
            <br>
            <br>
            <h2>Recensioni</h2>
            <br>
            <br>
            @foreach ($feedbacks as $feed)
                @if ($feed->recensione != null && $feed->recensione != '')
                    @php

                        $id_studente = $feed->student_id;
                        $studente = Student::where('id', '=', $id_studente)->first();
                    @endphp
                    <h4>{{ $studente->user->name . ' ' . $studente->user->surname }}</h4>
                    <p>{{ $feed->recensione }}</p>
                    <br>
                    <br>
                @else
                    <h4>Al momento non ci sono recensioni</h4>
                @endif
            @endforeach
        @endif
    </div>
@endsection
