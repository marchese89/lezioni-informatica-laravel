<?php

namespace App\Http\Utility;

use App\Models\Order;
use App\Models\OrderProduct;

function punteggioInsegnante($conn): float
{
    $conn->query("LOCK TABLES feedback READ");
    $result = $conn->query("SELECT * FROM feedback");
    $cont = 0;
    $somma = 0;
    while ($feed = $result->fetch_assoc()) {
        $punteggio = $feed['punteggio'];
        $cont = $cont + 1;
        $somma = $somma + $punteggio;
    }
    $conn->query("UNLOCK TABLES");
    if ($cont > 0)
        return $somma / $cont;
    else
        return 0;
}

class Data
{

    static function stampa_data($data)
    {
        $anno = substr($data, 0, 4);
        $mese = substr($data, 5, 2);
        $giorno = substr($data, 8, 2);
        $ora = substr($data, 11, 5);
        $r = array();
        $r['anno'] = $anno;
        $r['mese'] = $mese;
        $r['giorno'] = $giorno;
        $r['ora'] = $ora;

        return $r;
    }
}

class Acquisti
{
    public static function prodotto_acquistato($id_studente, $id, $tipo): bool
    {
        $ordini = Order::where('student_id', '=', $id_studente)->get();
        foreach ($ordini as $ordine) {
            $prodotti_ordine = OrderProduct::where('id_ordine', '=', $ordine->id)->get();
            foreach ($prodotti_ordine as $prodotto) {
                if ($prodotto->id_prodotto == $id && $prodotto->tipo_prodotto == $tipo) {
                    return true;
                }
            }
        }

        return false;
    }
}
