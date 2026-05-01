@extends('admin.dashboard-admin')

@section('inner')
    @php $enableEcho = true; @endphp
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        function invia_messaggio(testo) {
            if (!testo || testo.trim() === "") return;

            document.getElementById("messaggio").value = "";

            const xhr = new XMLHttpRequest();

            xhr.open("POST", "/chat/admin/invia-messaggio", true);

            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.setRequestHeader(
                "X-CSRF-TOKEN",
                document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            );

            const params = new URLSearchParams();
            params.append("id_chat", "{{ request('id') }}");
            params.append("aut", 1);
            params.append("testo", testo);
            xhr.send(params.toString());
        }
    </script>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard-admin">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="studenti">Studenti</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="chat-studenti">Chat Studenti</a>
        </li>
    </ul>
    <div style="text-align: center">
        <h2>Chat Con Studente</h2>
    </div>
    @php
        use App\Models\ChatMessage;
        use App\Models\Chat;
        use App\Models\User;
        use App\Models\Student;
        use App\Models\Lesson;
        use App\Models\LessonOnRequest;
        use App\Models\Exercise;
        use App\Helpers\DateHelper;
        $chat = Chat::where('id', '=', request('id'))->first();
        $tipo_prod = $chat->tipo_prodotto;
        $pres = '';
        $exec = '';
        $titolo = '';
        switch ($tipo_prod) {
            case 0:
                $lezione = Lesson::where('id', '=', $chat->id_prodotto)->first();
                $pres = $lezione->presentation;
                $exec = $lezione->lesson;
                $titolo = 'Lezione n. ' . $lezione->id . ', ' . $lezione->title;
                break;
            case 2:
                $esercizio = Exercise::where('id', '=', $chat->id_prodotto)->first();
                $pres = $esercizio->trace;
                $exec = $esercizio->execution;
                $titolo = 'Esercizio n. ' . $esercizio->id . ', ' . $esercizio->title;
                break;
            case 5:
                $lezione_su_rich = LessonOnRequest::where('id', '=', $chat->id_prodotto)->first();
                $pres = $lezione_su_rich->trace;
                $exec = $lezione_su_rich->execution;
                $titolo = 'Lezione su richiesta n. ' . $lezione_su_rich->id . ', ' . $lezione_su_rich->title;
                break;
            default:
                break;
        }

    @endphp
    <div style="text-align: center">
        <h3>{{ $titolo }}</h3>
        <h4>Presentazione</h4>

        <iframe width="70%" src="/protected_file/{{ $pres }}#view=FitH" height="800px"
            style="border-radius: 10px 10px 10px 10px">
        </iframe>
        <br>
        <br>
        <h4>Svolgimento</h4>

        <iframe width="70%" src="/protected_file/{{ $exec }}#view=FitH" height="800px"
            style="border-radius: 10px 10px 10px 10px">
        </iframe>
        <br>
        <br>
    </div>
    <div class="container" style="width: 70%">
        @php

            $messaggi = ChatMessage::where('chat_id', '=', request('id'))->orderBy('date', 'asc')->get();
            $studente = Student::where('id', '=', $chat->id_studente)->first();
            $utente = $studente->user;
        @endphp
        <div id="messaggi">
            @foreach ($messaggi as $item)
                @if ($item->author == 0)
                    <div class="chat-message" style="justify-content: flex-start;">
                        <div class="message-content">
                            <p class="sender-name">{{ $utente->name . ' ' . $utente->surname }}</p>
                            <p class="message-text">{{ $item->message }}</p>
                            <span class="timestamp">{{ DateHelper::format($item->date) }}</span>
                        </div>
                    </div>
                @else
                    <div class="chat-message" style="justify-content: flex-end;">
                        <div class="message-content" style="background-color: #5755c559;">
                            <p class="sender-name">Tu</p>
                            <p class="message-text">{{ $item->message }}</p>
                            <span class="timestamp">{{ DateHelper::format($item->date) }}</span>
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
    <script>
        function appendMessage(msg) {
            const html = `
        <div class="chat-message" style="justify-content: ${msg.author == 1 ? 'flex-end' : 'flex-start'};">
            <div class="message-content" style="${msg.author == 1 ? 'background-color: #5755c559;' : ''}">
                <p class="sender-name">${msg.author == 1 ? 'Tu' : 'Studente'}</p>
                <p class="message-text">${msg.message}</p>
                <span class="timestamp">${msg.date ?? ''}</span>
            </div>
        </div>
    `;

            const container = document.getElementById("messaggi");
            container.insertAdjacentHTML('beforeend', html);

            container.scrollTop = container.scrollHeight;
        }
    </script>
    <script>
        const chatId = {{ request('id') }};

        document.addEventListener('DOMContentLoaded', function() {

            const chatId = {{ request('id') }};

            if (!window.Echo) {
                console.error("Echo NON è disponibile");
                return;
            }

            window.Echo.channel('chat.' + chatId)
                .listen('.MessageSent', function(e) {
                    appendMessage(e);
                });

        });
    </script>
@endsection
