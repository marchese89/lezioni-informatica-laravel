@extends('admin.dashboard-admin')

@section('inner')
    <style>
        .cerchio {
            width: 40px;
            height: 40px;
            background-color: red;
            border-radius: 50%;
            display: inline-block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    @php
        include app_path('Http/Utility/funzioni.php');
        use App\Models\Chat;
        use App\Models\ChatMessage;
        use App\Models\Exercise;
        use App\Models\Lesson;
        use App\Models\LessonOnRequest;
        use App\Models\User;
        use App\Models\Student;
        use App\Http\Utility\Data;
        use Illuminate\Support\Facades\DB;
    @endphp
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard-admin">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="studenti">Studenti</a>
        </li>
    </ul>
    <div class="row g-0 container-fluid" style="text-align: center">
        <h2>Chat Studenti</h2>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tipo Prodotto</th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Studente</th>
                    <th scope="col">Stato</th>
                    <th scope="col">Operazioni</th>
                </tr>
            </thead>
            @php
                $prima_chat = DB::table('chats')
                    ->orderBy(DB::raw('created_at'), 'desc')
                    ->first();
                $data_primo = Data::stampa_data($prima_chat->created_at);
                $chat = DB::table('chats')
                    ->whereMonth('created_at', $data_primo['mese'])
                    ->whereYear('created_at', $data_primo['anno'])
                    ->orderBy(DB::raw('created_at'), 'desc')
                    ->get();
            @endphp
            <tbody>
                @foreach ($chat as $item)
                    <tr>

                        <th scope="row">{{ $item->id }}</th>
                        <td>
                            @php
                                $tipo_prod = $item->tipo_prodotto;
                                $tipo_stringa = '';
                                switch ($tipo_prod) {
                                    case 0:
                                        $tipo_stringa = 'Lezione';
                                        break;
                                    case 2:
                                        $tipo_stringa = 'Esercizio';
                                        break;
                                    case 5:
                                        $tipo_stringa = 'Lezione su Richiesta';
                                        break;
                                    default:
                                        break;
                                }
                            @endphp
                            {{ $tipo_stringa }}
                        </td>
                        <td>
                            @php
                                $nome = '';
                                switch ($tipo_prod) {
                                    case 0:
                                        $lezione = Lesson::where('id', '=', $item->id_prodotto)->first();
                                        $nome = $lezione->title;
                                        break;
                                    case 2:
                                        $esercizio = Exercise::where('id', '=', $item->id_prodotto)->first();
                                        $nome = $esercizio->title;
                                        break;
                                    case 5:
                                        $lezione_su_rich = LessonOnRequest::where('id', '=', $item->id_prodotto)->first();
                                        $nome = $lezione_su_rich->title;
                                        break;
                                    default:
                                        break;
                                }
                            @endphp
                            {{ $nome }}
                        </td>
                        <td>
                            @php
                                $studente = Student::where('id', '=', $item->id_studente)->first();
                                $utente = $studente->user;
                            @endphp
                            {{ $utente->name . ' ' . $utente->surname }}
                        </td>
                        <td style="text-align: center">
                            @php
                                $chat_ = ChatMessage::where('chat_id', '=', $item->id)
                                    ->orderBy('date', 'desc')
                                    ->first();
                                if ($chat_ != null && $chat_->author == 0) {
                                    echo '<div class="cerchio" style="background-color: red;"></div>';
                                } else {
                                    echo '<div class="cerchio" style="background-color: green;"></div>';
                                }
                            @endphp
                        </td>
                        <td>
                            <div>
                                <button type="submit" class="btn btn-primary"
                                    onclick=location.href="visualizza-chat-{{ $item->id }}">Visualizza Chat</button>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
