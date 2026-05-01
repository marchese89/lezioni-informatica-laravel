<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Helpers\DateHelper;
use App\Models\Student;
use App\Models\ChatMessage;
use App\Models\Chat;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Events\MessageSent;

class AjaxController extends Controller
{

    public function getOrdini(Request $request)
    {
        $anno = $request->input('anno');
        $mese = $request->input('mese');

        $query = Order::query()
            ->with('student.user')
            ->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id')
            ->select(
                'orders.id',
                'orders.date',
                'orders.student_id',
                DB::raw('SUM(order_products.price) as totale')
            )
            ->whereMonth('orders.date', $mese)
            ->whereYear('orders.date', $anno)
            ->groupBy('orders.id', 'orders.date', 'orders.student_id');

        // filtro studente
        if (auth()->user()->student !== null) {
            $query->where('orders.student_id', auth()->user()->student->id);
        }

        $ordini = $query
            ->orderByDesc('orders.date')
            ->get();

        // mapping leggero (niente più calcoli)
        $ordiniMapped = $ordini->map(function ($order) {
            return [
                'id' => $order->id,
                'data' => DateHelper::format($order->date),
                'totale' => $order->totale ?? 0,
                'studente' => $order->student->user->name . ' ' . $order->student->user->surname,
            ];
        });

        return response()->json([
            'ordini' => $ordiniMapped,
            'totale' => $ordiniMapped->sum('totale'),
        ]);
    }

    public function invia_messaggio(Request $request)
    {
        $request->validate([
            'id_chat' => 'required|integer|exists:chats,id',
            'testo' => 'required|string'
        ]);

        $messaggio = ChatMessage::create([
            'chat_id' => $request->id_chat,
            'message' => $request->testo,
            'author' => auth()->user()->role === 'admin' ? 1 : 0
        ]);

        broadcast(new MessageSent($messaggio));

        return response()->json([
            'success' => true,
            'message' => $messaggio
        ]);
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
                            <span class="timestamp">' . DateHelper::format($item->date) . '</span>
                        </div>
                    </div>';
            } else {
                $html = $html .
                    '<div class="chat-message" style="justify-content: flex-end;">
                        <div class="message-content" style="background-color: #5755c559;">
                            <p class="sender-name">Tu</p>
                            <p class="message-text">' . $item->message . '</p>
                            <span class="timestamp">' . DateHelper::format($item->date) . '</span>
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
                            <span class="timestamp">' . DateHelper::format($item->date) . '</span>
                        </div>
                    </div>';
            } else {
                $html = $html .
                    '<div class="chat-message" style="justify-content: flex-end;">
                        <div class="message-content" style="background-color: #5755c559;">
                            <p class="sender-name">Tu</p>
                            <p class="message-text">' . $item->message . '</p>
                            <span class="timestamp">' . DateHelper::format($item->date) . '</span>
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
