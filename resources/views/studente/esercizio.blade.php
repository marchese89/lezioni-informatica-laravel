@extends('admin.dashboard-admin')

@section('inner')
    @php
        include app_path('Http/Utility/funzioni.php');
        use App\Models\Course;
        use App\Models\Lesson;
        use App\Models\ChatMessage;
        use App\Models\Chat;
        use App\Models\User;
        use App\Models\Student;
        use App\Models\LessonOnRequest;
        use App\Models\Exercise;
        use App\Http\Utility\Data;

        $chat = Chat::where('id_prodotto', '=', request('id_esercizio'))
            ->where('tipo_prodotto', '=', 2)
            ->where('id_studente', '=', auth()->user()->student->id)
            ->first();
    @endphp
    <script type="text/javascript">
        setInterval(leggi_messaggi, 1000);

        function leggi_messaggi() {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    _("messaggi").innerHTML = this.responseText;
                }
            };
            //aut=1 -> insegnante
            xmlhttp.open("GET", "leggi-messaggi-studente-" + <?php echo $chat->id; ?>, true);
            xmlhttp.send();
        }

        function invia_messaggio(testo) {
            _("messaggio").value = "";
            if (testo == "") {
                return;
            } else {
                let xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText);
                    }
                };
                //aut=1 -> insegnante
                xmlhttp.open("GET", "studente-invia-messaggio-" + <?php echo $chat->id; ?> + "-0-" + testo, true);
                xmlhttp.send();
            }

        }
    </script>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard-studente">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="corsi">Corsi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="visualizza-corso-{{ request('id_corso') }}">Corso</a>
        </li>
    </ul>
    <div class="container" style="text-align: center;width:100%">
        @php

            $id_corso = request('id_corso');
            $id_esercizio = request('id_esercizio');
            $corso = Course::where('id', '=', $id_corso)->first();
            $esercizio = Exercise::where('id', '=', $id_esercizio)->first();

        @endphp
        <h2>Modifica Esercizio Corso di</h2>
        <h2>"{{ $corso->name }}"</h2>
        <h3>Titolo Esercizio</h3>
        <h3>"{{ $esercizio->title }}"</h3>
        <br>

        <br>
        <h4>Traccia</h4>

        <iframe width="90%" src="/protected_file/{{ $esercizio->trace }}#view=FitH" height="800px">
        </iframe>
        <br>
        <br>
        <h4>Svolgimento</h4>
        <iframe width="90%" src="/protected_file/{{ $esercizio->execution }}#view=FitH" height="800px">
        </iframe>
        <br>
        <br>
        <div class="container" style="width: 70%;text-align:center">
            <h2>Chat di Supporto</h2>
            <br>
            <br>
            @php

                $messaggi = ChatMessage::where('chat_id', '=', $chat->id)
                    ->orderBy('date', 'asc')
                    ->get();
                $studente = Student::where('id', '=', $chat->id_studente)->first();
                $utente = $studente->user;
            @endphp
            <div id="messaggi">
                @foreach ($messaggi as $item)
                    @if ($item->author == 1)
                        <div class="chat-message" style="justify-content: flex-start;">
                            <div class="message-content">
                                <p class="sender-name">Insegnante</p>
                                <p class="message-text">{{ $item->message }}</p>
                                <span class="timestamp">{{ Data::stampa_stringa_data($item->date) }}</span>
                            </div>
                        </div>
                    @else
                        <div class="chat-message" style="justify-content: flex-end;">
                            <div class="message-content" style="background-color: #5755c559;">
                                <p class="sender-name">Tu</p>
                                <p class="message-text">{{ $item->message }}</p>
                                <span class="timestamp">{{ Data::stampa_stringa_data($item->date) }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div style="text-align: center">
                <textarea id="messaggio" name="messaggio" rows="5" cols="100"
                    style="width: 80%; font-size: 18px; resize: none; border-radius: 5px 5px 5px 5px"></textarea>

                <script type="text/javascript">
                    var input = _("messaggio");

                    //Execute a function when the user presses a key on the keyboard
                    input.addEventListener("keypress", function(event) {
                        // If the user presses the "Enter" key on the keyboard
                        if (event.key === "Enter") {
                            // Cancel the default action, if needed
                            event.preventDefault();
                            // Trigger the button element with a click
                            _("invia").click();
                        }
                    });
                </script> <br>
                <button id="invia" class="btn btn-primary" onclick=invia_messaggio(_("messaggio").value)>Invia</button>
                <br>
                <br>
            </div>
        </div>
    </div>
@endsection
