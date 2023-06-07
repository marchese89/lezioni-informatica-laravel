<?php

namespace App\Http\Controllers\Admin;

include app_path('Http/Utility/funzioni.php');

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Utility\Acquisti;
use App\Http\Utility\Data;
use App\Models\User;
use App\Models\Student;
use App\Models\ChatMessage;
use App\Models\Chat;
use App\Models\Feedback;

class AjaxController extends Controller
{
    public function cambia_tabella_ordini()
    {
        $anno = request('anno');
        $mese = request('mese');

        $ordine = DB::table('orders')
            ->whereMonth('date', $mese)
            ->whereYear('date', $anno)
            ->orderBy(DB::raw('date'), 'desc')
            ->get();

        $html =

            '<thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Studente</th>
                    <th scope="col">Data</th>
                    <th scope="col">Totale</th>
                    <th scope="col">Visualizza</th>
                </tr>
            </thead><tbody>';

        $totale = 0;
        foreach ($ordine as $item) {
            $html = $html .
                '<tr>

                        <th scope="row">' .  $item->id .  '</th>
                        <td>';

            $studente = Student::where('id', '=', $item->student_id)->first();
            $utente = $studente->user;
            $html = $html .  $utente->name . ' ' . $utente->surname;
            $html = $html .
                '</td>
                        <td>';
            $html = $html .  Data::stampa_stringa_data($item->date);
            $html = $html .
                '</td>
                        <td>';
            $html = $html .   Acquisti::get_totale_ordine($item->id) . '<strong>&euro;</strong>';

            $totale = $totale + Acquisti::get_totale_ordine($item->id);
            $html = $html .
                '</td>
                        <td><button class="btn btn-primary"
                                onclick=location.href="admin-ordine-' . $item->id . '">Visualizza Ordine</button></td>
                    </tr>';
        }
        $html = $html .
            '<tr>
                    <td colspan="5"><strong>Totale:' . $totale . '&euro;</strong></td>
                </tr>
            </tbody>';

        return $html;
    }

    public function cambia_tabella_ordini_studente()
    {
        $anno = request('anno');
        $mese = request('mese');

        $ordine = DB::table('orders')
            ->whereMonth('date', $mese)
            ->whereYear('date', $anno)
            ->orderBy(DB::raw('date'), 'desc')
            ->get();

        $html =

            '<thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Studente</th>
                    <th scope="col">Data</th>
                    <th scope="col">Totale</th>
                    <th scope="col">Visualizza</th>
                </tr>
            </thead><tbody>';

        $totale = 0;
        foreach ($ordine as $item) {
            $html = $html .
                '<tr>

                        <th scope="row">' .  $item->id .  '</th>
                        <td>';

            $studente = Student::where('id', '=', $item->student_id)->first();
            $utente = $studente->user;
            $html = $html .  $utente->name . ' ' . $utente->surname;
            $html = $html .
                '</td>
                        <td>';
            $html = $html .  Data::stampa_stringa_data($item->date);
            $html = $html .
                '</td>
                        <td>';
            $html = $html .   Acquisti::get_totale_ordine($item->id) . '<strong>&euro;</strong>';

            $totale = $totale + Acquisti::get_totale_ordine($item->id);
            $html = $html .
                '</td>
                        <td><button class="btn btn-primary"
                                onclick=location.href="ordine-' . $item->id . '">Visualizza Ordine</button></td>
                    </tr>';
        }
        $html = $html .
            '<tr>
                    <td colspan="5"><strong>Totale:' . $totale . '&euro;</strong></td>
                </tr>
            </tbody>';

        return $html;
    }

    public function invia_messaggio()
    {
        $id_chat = request('id_chat');
        $autore = request('aut');
        $testo = request('testo');
        $messaggio_chat = new ChatMessage();
        $messaggio_chat->chat_id = $id_chat;
        $messaggio_chat->message = $testo;
        $messaggio_chat->author = $autore;
        $messaggio_chat->save();
    }

    public function leggi_messaggi()
    {
        $id_chat = request('id_chat');
        $chat = Chat::where('id', '=', $id_chat)->first();
        $messaggi = ChatMessage::where('chat_id', '=', $id_chat)
            ->orderBy('date', 'asc')
            ->get();
        $studente = Student::where('id', '=', $chat->id_studente)->first();
        $utente = $studente->user;
        $html = "";
        foreach ($messaggi as $item)
            if ($item->author == 0) {
                $html = $html .
                    '<div class="chat-message" style="justify-content: flex-start;">
                        <div class="message-content">
                            <p class="sender-name">' . $utente->name . ' ' . $utente->surname . '</p>
                            <p class="message-text">' . $item->message . '</p>
                            <span class="timestamp">' . Data::stampa_stringa_data($item->date) . '</span>
                        </div>
                    </div>';
            } else {
                $html = $html .
                    '<div class="chat-message" style="justify-content: flex-end;">
                        <div class="message-content" style="background-color: #5755c559;">
                            <p class="sender-name">Tu</p>
                            <p class="message-text">' . $item->message . '</p>
                            <span class="timestamp">' . Data::stampa_stringa_data($item->date) . '</span>
                        </div>
                    </div>';
            }

        return $html;
    }

    public function leggi_messaggi_stud()
    {
        $id_chat = request('id_chat');
        $chat = Chat::where('id', '=', $id_chat)->first();
        $messaggi = ChatMessage::where('chat_id', '=', $id_chat)
            ->orderBy('date', 'asc')
            ->get();
        $studente = Student::where('id', '=', $chat->id_studente)->first();
        $utente = $studente->user;
        $html = "";
        foreach ($messaggi as $item)
            if ($item->author == 1) {
                $html = $html .
                    '<div class="chat-message" style="justify-content: flex-start;">
                        <div class="message-content">
                            <p class="sender-name">Insegnante</p>
                            <p class="message-text">' . $item->message . '</p>
                            <span class="timestamp">' . Data::stampa_stringa_data($item->date) . '</span>
                        </div>
                    </div>';
            } else {
                $html = $html .
                    '<div class="chat-message" style="justify-content: flex-end;">
                        <div class="message-content" style="background-color: #5755c559;">
                            <p class="sender-name">Tu</p>
                            <p class="message-text">' . $item->message . '</p>
                            <span class="timestamp">' . Data::stampa_stringa_data($item->date) . '</span>
                        </div>
                    </div>';
            }

        return $html;
    }

    public function invia_feedback()
    {
        $punteggio = request('punteggio');
        //cerchiamo per vedere se c'è già un punteggio assegnato
        $id_studente = auth()->user()->student->id;
        $feedback = Feedback::where('student_id', '=', $id_studente)->first();
        if ($feedback != null) {
            $feedback->punteggio = $punteggio;
        } else {
            $feedback = new Feedback();
            $feedback->student_id = $id_studente;
            $feedback->punteggio = $punteggio;
        }

        $feedback->save();

        $response = '<a ';
        if ($punteggio > 0) {
            $response = $response . 'style="opacity: 100%;"';
        }
        $response = $response . ' onclick="invia_feefback(1)">⭐</a>
    <a ';
        if ($punteggio > 1) {
            $response = $response . 'style="opacity: 100%;"';
        }
        $response = $response .  ' onclick="invia_feefback(2)">⭐</a>
    <a ';
        if ($punteggio > 2) {
            $response = $response . 'style="opacity: 100%;"';
        }
        $response = $response . ' onclick="invia_feefback(3)">⭐</a>
    <a ';
        if ($punteggio > 3) {
            $response = $response . 'style="opacity: 100%;"';
        }
        $response = $response . ' onclick="invia_feefback(4)">⭐</a>
    <a ';
        if ($punteggio > 4) {
            $response = $response . 'style="opacity: 100%;"';
        }
        $response = $response .   ' onclick="invia_feefback(5)">⭐</a>';

        return $response;
    }

    public function invia_recensione()
    {
        $testo = request('testo');
        $id_studente = auth()->user()->student->id;
        $feedback = Feedback::where('student_id', '=', $id_studente)->first();
        if ($feedback != null) {
            $feedback->recensione = $testo;
        } else {
            $feedback = new Feedback();
            $feedback->student_id = $id_studente;
            $feedback->recensione = $testo;
        }

        $feedback->save();
        return $testo;
    }
}
