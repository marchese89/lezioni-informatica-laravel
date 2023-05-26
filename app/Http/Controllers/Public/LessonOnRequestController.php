<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\LessonOnRequest;

class LessonOnRequestController extends Controller
{
    public function add_file_su_richiesta(Request $request)
    {
        if ($request->session()->exists('uploaded_lez_rich')) {
            if (File::exists(storage_path('/app/private/') . $request->session()->get('uploaded_lez_rich'))) {
                File::delete(storage_path('/app/private/') . $request->session()->get('uploaded_lez_rich'));
            }
        }
        $request->session()->forget('uploaded_lez_rich');
        $file = $request->file('file');
        $name = $file->hashName();
        $file->move(storage_path('/app/private/'), $name);

        $request->session()->put('uploaded_lez_rich', $name);

        return redirect('lezione-su-richiesta');
    }

    public function elimina_lez_rich(Request $request)
    {
        if ($request->session()->exists('uploaded_lez_rich')) {
            if (File::exists(storage_path('/app/private/') . $request->session()->get('uploaded_lez_rich'))) {
                File::delete(storage_path('/app/private/') . $request->session()->get('uploaded_lez_rich'));
            }
            $request->session()->forget('uploaded_lez_rich');
        }
        return redirect('lezione-su-richiesta');
    }

    public function carica_lez_rich(Request $request)
    {
        $titolo = request('titolo');
        $lez_su_rich = new LessonOnRequest();
        $lez_su_rich->title = $titolo;
        $lez_su_rich->student_id = $request->user()->student->id;
        $lez_su_rich->trace = $request->session()->get('uploaded_lez_rich');
        $lez_su_rich->save();
        $request->session()->forget('uploaded_lez_rich');

        return redirect('esito-lez-rich');
    }

    public function sol_rich_upload(Request $request)
    {
        $id = request('id');

        $lezione = LessonOnRequest::where('id','=',$id)->first();

        if(File::exists(storage_path('/app/private/') . $lezione->execution)){
            File::delete(storage_path('/app/private/') . $lezione->execution);
        }

        $file = $request->file('file');
        $name = $file->hashName();
        $file->move(storage_path('/app/private/'),$name);

        $lezione->execution = $name;

        $lezione->save();

        return redirect('visualizza-richiesta-'. $id);

    }

    public function lez_rich_rem_exec()
    {
        $id = request('id');

        $lezione = LessonOnRequest::where('id','=',$id)->first();

        if(File::exists(storage_path('/app/private/') . $lezione->execution)){
            File::delete(storage_path('/app/private/') . $lezione->execution);
        }

        $lezione->execution = null;

        $lezione->save();

        return redirect('visualizza-richiesta-'. $id);
    }

    public function carica_prezzo_lez_rich()
    {
        $id = request('id');

        $prezzo = request('prezzo');

        $lezione = LessonOnRequest::where('id','=',$id)->first();

        $lezione->price = $prezzo;

        $lezione->escaped = 1;

        $lezione->save();

        return redirect('visualizza-richiesta-'. $id);
    }
}
