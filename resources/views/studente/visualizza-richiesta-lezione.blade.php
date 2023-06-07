@extends('studente.dashboard-studente')

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

        $richiesta = LessonOnRequest::where('id', '=', request('id'))->first();

        $chat = Chat::where('id_prodotto', '=', request('id'))
            ->where('tipo_prodotto', '=', 5)
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
        @if ($richiesta->paid == 0)
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="richieste-dirette">Richieste Dirette</a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="richieste-dirette-acquistate">Richieste Dirette</a>
            </li>
        @endif
    </ul>
    <div class="container" style="text-align: center">
        <h3>Richiesta Lezione: </h3>
        <h3 style="color: blue">{{ $richiesta->title }}</h3>
        <h4>Traccia</h4>

        <iframe width="90%" src="/protected_file/{{ $richiesta->trace }}#view=FitH" height="800px">
        </iframe>
        <br>
        <br>
        @if ($richiesta->price != null && $richiesta->price != 0 && $richiesta->paid == 0)
            <div class="col-md-12">
                <h5>Prezzo</h5>
                <label>{{ $richiesta->price }} &nbsp;<strong>&euro;</strong></label>
            </div>
            <br>
            <div class="col-12" style="text-align:center">
                <button type="submit" class="btn btn-primary"
                    onclick=location.href="aggiungi-al-carrello-{{ $richiesta->id }}-5">Acquista</button>
            </div>
        @endif
        @if ($richiesta->paid == 1)
            <br>
            <br>
            <h4>Soluzione</h4>
            <iframe width="90%" src="/protected_file/{{ $richiesta->execution }}#view=FitH" height="800px">
            </iframe>
            <br>
            <br>
        @endif
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
    </div>
@endsection
