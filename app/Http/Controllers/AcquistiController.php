<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Utility\Carrello;
use App\Http\Utility\ElementoC;
use App\Models\Exercise;
use App\Models\Lesson;

class AcquistiController extends Controller
{
    public function aggiungi_al_carrello(Request $request)
    {
        $id = request('id');
        $type = request('type');
        $carrello = $request->session()->get('carrello');
        $elemento =  new ElementoC($id, $type);
        $carrello->aggiungi($elemento);
        if ($type == 0) { //lezione
            $lezione = Lesson::where('id', '=', $id)->first();
            return redirect('corso-' . $lezione->course_id);
        }
        if ($type == 2) { //esercizio
            $esercizio = Exercise::where('id', '=', $id)->first();
            return redirect('corso-' . $esercizio->course_id);
        }
        if ($type == 1 || $type == 4) {
            return  redirect('corso-' . $id);
        }
    }

    public function rimuovi_dal_carrello(Request $request)
    {
        $id = request('id');
        $type = request('type');
        $carrello = $request->session()->get('carrello');
        $carrello->rimuovi($id,$type);
        return redirect('visualizza-carrello');
    }
}
