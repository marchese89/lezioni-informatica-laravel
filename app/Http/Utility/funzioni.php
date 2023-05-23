<?php

namespace App\Http\Utility;

function prodotto_acquistato($cliente, $id, $tipo, $conn): bool
{
    $conn->query("LOCK TABLES ordine READ, prodotti_ordine READ");
    $result = $conn->query("SELECT * FROM ordine WHERE cliente='$cliente'");
    while ($ordine = $result->fetch_assoc()) {
        $id_ordine = $ordine['id'];
        $result2 = $conn->query("SELECT * FROM prodotti_ordine WHERE id_ordine='$id_ordine'");
        while ($prod = $result2->fetch_assoc()) {
            if ($prod['prodotto'] == $id && $prod['tipo'] == $tipo) {
                $conn->query("UNLOCK TABLES");
                return TRUE;
            }
        }
    }
    $conn->query("UNLOCK TABLES");
    return FALSE;
}



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
