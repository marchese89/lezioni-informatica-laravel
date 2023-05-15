<?php

namespace App\Http\Utility;

use Illuminate\Support\Facades\DB;
use App\Models\Lesson;
use App\Models\Exercise;
use App\Models\LessonOnRequest;
use App\Models\Course;

class ElementoC
{

    private $idProdotto;

    private $prezzo;

    // tipi: 0=lezione, 1=tutte le lezioni di un corso, 2=esercizio, 3=tutti gli esercizi di un corso
    // 4= tutte le lezioni e tutti gli esercizi di un corso, 5=lezione su richiesta
    private $tipoElemento = 0;

    private $nome;

    public function __construct($id, $tipo_elem)
    {
        DB::beginTransaction();

        $this->idProdotto = $id;
        $this->tipoElemento = $tipo_elem;
        switch ($this->tipoElemento) {
            case 0: // lezione
                $lezione = Lesson::where('id', '=', $id)->first();
                $this->nome = $lezione->title;
                $this->prezzo = $lezione->price;
                break;
            case 1: // tutte le lezioni di un corso
                $corso = Course::where('id', '=', $id)->first();
                $this->nome = "Tutte le lezioni: " . $corso->name;
                break;
            case 2: // esercizio
                $ex = Exercise::where('id', '=', $id)->first();
                $this->nome = $ex->title;
                $this->prezzo = $ex->price;
                break;
            case 3: // tutti gli esercizi di un corso
                $corso = Course::where('id', '=', $id)->first();
                $this->nome = "Tutti gli esercizi: " . $corso->name;
                break;
            case 4: // tutte le lezioni e tutti gli esercizi di un corso
                $corso = Course::where('id', '=', $id)->first();
                $this->nome = "Corso Completo: " . $corso->name;
                break;
            case 5:
                $rich = LessonOnRequest::where('id', '=', $id)->first();
                $this->nome = "Lezione su richiesta: " . $rich->title;
                $this->prezzo = $rich->price;
                break;
            default:
                break;
        }
        DB::commit();

    }

    public function getId()
    {
        return $this->idProdotto;
    }

    public function getTipoElemento()
    {
        return $this->tipoElemento;
    }

    public function getPrezzo()
    {
        return $this->prezzo;
    }

    public function setPrezzo($prezzo)
    {
        $this->prezzo = $prezzo;
    }

    public function getNome()
    {
        return $this->nome;
    }
}

class Carrello
{

    private $elementi;

    public function __construct()
    {
        $this->elementi = array();
    }

    public function aggiungi(ElementoC $elem)
    {
        $id = $elem->getId();
        $tipo = $elem->getTipoElemento();
        // verifichiamo se l'elemento è già presente
        $ind = $this->trovaElemento($id, $tipo);
        if ($ind !== -1) {
            return TRUE;
        }
        DB::beginTransaction();
        // verifichiamo se è già presente un insieme che include già l'elemento (niente da inserire)
        // il tipo è una lezione
        if ($tipo === 0) {
            $lez = Lesson::where('id','=',$id)->first();
            $id_corso = $lez->course_id;
            $ind = $this->trovaElemento($id_corso, 1); // tutte le lezioni
            if ($ind !== -1) {
                return TRUE;
            }
            $ind = $this->trovaElemento($id_corso, 4); // tutte le lezioni e tutti gli esercizi
            if ($ind !== -1) {
                return TRUE;
            }
        }

        // il tipo è un esercizio
        if ($tipo === 2) {
            $ex = Exercise::where('id','=',$id)->first();
            $id_corso = $ex->course_id;
            $ind = $this->trovaElemento($id_corso, 3); // tutti gli esercizi
            if ($ind !== -1) {
                return TRUE;
            }
            $ind = $this->trovaElemento($id_corso, 4); // tutte le lezioni e tutti gli esercizi
            if ($ind !== -1) {
                return TRUE;
            }
        }

        // verifichiamo se è già presente una lezione o un esercizio e stiamo aggiungendo l'insieme grande
        // (eliminazione di tutti gli elementi già inseriti che fanno parte dell'insieme che stiamo inserendo)
        // stiamo aggiungendo tutte le lezioni di un corso (eliminiamo tutte le lezioni singole già eventualmente
        // inserite
        if ($tipo === 1) { // tutte le lezioni
            $lessons = Lesson::where('course_id','=',$id)->get();
            foreach($lessons as $lesson){
                $id_lez = $lesson->id;
                $ind = $this->trovaElemento($id_lez, 0);
                if ($ind !== -1) { // la lezione esiste già e va cancellata
                    $this->rimuovi($id_lez, 0);
                }
            }
            $ind = $this->trovaElemento($id, 4); // tutte le lezioni e tutti gli esercizi
            if ($ind !== -1) {
                return TRUE;
            }
        }

        if ($tipo === 3) { // inseriamo tutti gli esercizi di un corso (eliminiamo quelli singoli)
            $exercises = Exercise::where('course_id','=',$id)->get();
            foreach($exercises as $ex){
                $id_ex = $ex->id;
                $ind = $this->trovaElemento($id_ex, 2);
                if ($ind !== -1) { // la lezione esiste già e va cancellata
                    $this->rimuovi($id_ex, 2);
                }
            }

            $ind = $this->trovaElemento($id, 4); // tutte le lezioni e tutti gli esercizi
            if ($ind !== -1) {
                return TRUE;
            }
        }

        if ($tipo === 4) { // inseriamo tutte le lezioni e tutti gli esercizi di un corso (eliminiamo tutti i singoli)
            $lessons = Lesson::where('course_id','=',$id)->get();
            foreach($lessons as $lesson){
                $id_lez = $lesson->id;
                $ind = $this->trovaElemento($id_lez, 0);
                if ($ind !== -1) { // la lezione esiste già e va cancellata
                    $this->rimuovi($id_lez, 0);
                }
            }

            $exercises = Exercise::where('course_id','=',$id)->get();
            foreach($exercises as $ex){
                $id_ex = $ex->id;
                $ind = $this->trovaElemento($id_ex, 2);
                if ($ind !== -1) { // la lezione esiste già e va cancellata
                    $this->rimuovi($id_ex, 2);
                }
            }

            // cerchiamo gli insiemi (tutte le lezioni/tutti gli esercizi)
            if ($this->trovaElemento($id, 1) !== -1) {
                $this->rimuovi($id, 1);
            }

            if ($this->trovaElemento($id, 3) !== -1) {
                $this->rimuovi($id, 3);
            }
        }

        if ($tipo === 5) {
            if ($this->trovaElemento($id, $tipo) !== -1) {
                return TRUE;
            }
        }

        DB::commit();

        array_push($this->elementi, $elem);
        return TRUE;
    }

    public function rimuovi($id, $tipo)
    {
        $index = $this->trovaElemento($id, $tipo);
        if ($index !== -1) {
            unset($this->elementi[$index]);
            $this->elementi = array_merge($this->elementi);
            return TRUE;
        }
        return FALSE;
    }

    private function trovaElemento($id, $tipo)
    {
        $index = -1;
        for ($i = 0; $i < count($this->elementi); $i++) {
            $elemento = $this->elementi[$i];
            if ($elemento->getId() == $id && $elemento->getTipoElemento() == $tipo) {
                $index = $i;
                break;
            }
        }
        return $index;
    }

    public function contenuto()
    {
        return $this->elementi;
    }

    public function nElementi()
    {
        return count($this->elementi);
    }

    public function getTotale()
    {
        $tot = 0;
        foreach ($this->elementi as $p) {
            $tot += $p->getPrezzo();
        }
        return $tot;
    }

    function vuotaCarrello()
    {
        for ($index = 0; $index < count($this->elementi); $index++) {
            unset($this->elementi[$index]);
        }
        unset($this->elementi);
        $this->elementi = array();
    }
}
