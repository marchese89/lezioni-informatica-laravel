<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThemeArea;
use App\Models\Matter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Exercise;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CorsiController extends Controller
{
    public function nuova_area_tematica(){
        $nome = request('area-t');
        $theme_area = new ThemeArea();
        $theme_area->name = $nome;
        $theme_area->save();
        return redirect('aree-tem');
    }

    public function modifica_area_tematica(){
        $id = request('id');
        $nome = request('nome');

        $area_t = ThemeArea::where('id','=',$id)->first();

        $area_t->name = $nome;

        $area_t->save();

        return redirect('aree-tem');

    }

    public function elimina_area_tematica(){
        $id = request('id');
        $area_t = ThemeArea::where('id','=',$id)->first();
        $area_t->delete();
        return redirect('aree-tem');
    }

    public function nuova_materia(){
        $id_at = request('area-t');
        $materia = request('materia');
        $area_t = ThemeArea::where('id','=',$id_at)->first();

        $matter = new Matter();
        $matter->name = $materia;
        $matter->theme_area_id = $area_t->id;

        $matter->save();

        return redirect('materie');

    }

    public function modifica_materia(){
        $id = request('id');
        $nome = request('nome');

        $materia = Matter::where('id','=',$id)->first();

        $materia->name = $nome;

        $materia->save();

        return redirect('materie');
    }

    public function elimina_materia(){
        $id = request('id');
        $materia = Matter::where('id','=',$id)->first();
        $materia->delete();
        return redirect('materie');
    }

    public function nuovo_corso(){
        $id_materia = request('materia');
        $nome_corso = request('corso');

        $corso = new Course();

        $corso->matter_id = $id_materia;
        $corso->name = $nome_corso;

        $corso->save();

        return redirect('nuovo-corso');

    }

    public  function modifica_corso(){
        $id_corso = request('id');
        $nome_corso = request('nome');

        $corso = Course::where('id','=',$id_corso)->first();

        $corso->name = $nome_corso;

        $corso->save();

        return redirect('nuovo-corso');

    }

    public function elimina_corso(){
        $id_corso = request('id');

        $corso = Course::where('id','=',$id_corso)->first();

        $corso->delete();

        return redirect('nuovo-corso');
    }
    //LEZIONI
    public function upload_pres_lez(Request $request)
    {

        if($request->session()->exists('uploaded_pres_lez')){
            if(File::exists(storage_path('/app/private/') . $request->session()->get('uploaded_pres_lez'))){
                File::delete(storage_path('/app/private/') . $request->session()->get('uploaded_pres_lez'));
            }
        }
        $request->session()->forget('uploaded_pres_lez');
        $file = $request->file('file-pres-lez');
        $name = $file->hashName();
        $file->move(storage_path('/app/private/'),$name);

        $request->session()->put('uploaded_pres_lez',$name);

        return redirect('nuova-lezione-'. request('id'));

    }


    public function cancella_file_sessione(Request $request){
        if($request->session()->exists('uploaded_pres_lez')){
            File::delete(storage_path('/app/private/') . $request->session()->get('uploaded_pres_lez'));
        }
        $request->session()->forget('uploaded_pres_lez');
        return redirect('nuova-lezione-'. request('id'));
    }

    public function upload_lesson(Request $request)
    {

        if($request->session()->exists('uploaded_lesson')){
            if(File::exists(storage_path('/app/private/') . $request->session()->get('uploaded_lesson'))){
                File::delete(storage_path('/app/private/') . $request->session()->get('uploaded_lesson'));
            }
        }
        $request->session()->forget('uploaded_lesson');
        $file = $request->file('file-lesson');
        $name = $file->hashName();
        $file->move(storage_path('/app/private/'),$name);

        $request->session()->put('uploaded_lesson',$name);

        return redirect('nuova-lezione-'. request('id'));

    }


    public function cancella_file_sessione_lezione(Request $request){
        if($request->session()->exists('uploaded_lesson')){
            File::delete(storage_path('/app/private/') . $request->session()->get('uploaded_lesson'));
        }
        $request->session()->forget('uploaded_lesson');
        return redirect('nuova-lezione-'. request('id'));
    }

    public function carica_lezione(Request $request){
        $id_corso = request('id');
        $numero = request('numero');
        $titolo = request('titolo');
        $prezzo = request('prezzo');

        $lesson = new Lesson();

        $lesson->title = $titolo;
        $lesson->number = $numero;
        $lesson->course_id = $id_corso;
        $lesson->presentation = $request->session()->get('uploaded_pres_lez');
        $lesson->lesson = $request->session()->get('uploaded_lesson');
        $lesson->price = $prezzo;

        $lesson->save();

        $request->session()->forget('uploaded_pres_lez');
        $request->session()->forget('uploaded_lesson');

        return redirect('modifica-dettagli-corso-'. $id_corso);

    }

    public function elimina_lezione(Request $request){
        $lezione = Lesson::where('id','=',request('id'))->first();
        File::delete(storage_path('/app/private/') . $lezione->presentation);
        File::delete(storage_path('/app/private/') . $lezione->lesson);
        $lezione->delete();
        return redirect('modifica-dettagli-corso-'. request('id_corso'));
    }

    public function re_upload_pres_lez(Request $request)
    {
        $id_lezione = request('id');

        $lezione = Lesson::where('id','=',$id_lezione)->first();

        File::delete(storage_path('/app/private/') . $lezione->presentation);

        $file = $request->file('file-pres-lez');
        $name = $file->hashName();
        $file->move(storage_path('/app/private/'),$name);

        $lezione->presentation = $name;

        $lezione->save();

        return redirect('modifica-lezione-'. request('id_corso'). '-' . $id_lezione);

    }

    public function re_upload_lesson(Request $request)
    {

        $id_lezione = request('id');

        $lezione = Lesson::where('id','=',$id_lezione)->first();

        File::delete(storage_path('/app/private/') . $lezione->lesson);

        $file = $request->file('file-lesson');
        $name = $file->hashName();
        $file->move(storage_path('/app/private/'),$name);

        $lezione->lesson = $name;

        $lezione->save();

        return redirect('modifica-lezione-'. request('id_corso'). '-' . $id_lezione);

    }

    public function modifica_lezione(Request $request){

        $id_lezione = request('id_lezione');
        $numero = request('numero');
        $titolo = request('titolo');
        $prezzo = request('prezzo');

        $lesson = Lesson::where('id','=',$id_lezione)->first();


        $lesson->title = $titolo;
        $lesson->number = $numero;
        $lesson->price = $prezzo;

        $lesson->save();

        return redirect('modifica-lezione-'. request('id_corso'). '-' . $id_lezione);

    }

    //ESERCIZI

    public function upload_trace_ex(Request $request)
    {

        if($request->session()->exists('uploaded_trace_ex')){
            if(File::exists(storage_path('/app/private/') . $request->session()->get('uploaded_trace_ex'))){
                File::delete(storage_path('/app/private/') . $request->session()->get('uploaded_trace_ex'));
            }
        }
        $request->session()->forget('uploaded_trace_ex');
        $file = $request->file('file-trace-ex');
        $name = $file->hashName();
        $file->move(storage_path('/app/private/'),$name);

        $request->session()->put('uploaded_trace_ex',$name);

        return redirect('nuovo-esercizio-'. request('id'));

    }


    public function cancella_file_sessione_trace_ex(Request $request){

        if($request->session()->exists('uploaded_trace_ex')){
            File::delete(storage_path('/app/private/') . $request->session()->get('uploaded_trace_ex'));
        }
        $request->session()->forget('uploaded_trace_ex');
        return redirect('nuovo-esercizio-'. request('id'));

    }

    public function upload_ex(Request $request)
    {

        if($request->session()->exists('uploaded_ex')){
            if(File::exists(storage_path('/app/private/') . $request->session()->get('uploaded_ex'))){
                File::delete(storage_path('/app/private/') . $request->session()->get('uploaded_ex'));
            }
        }
        $request->session()->forget('uploaded_ex');
        $file = $request->file('file-ex');
        $name = $file->hashName();
        $file->move(storage_path('/app/private/'),$name);

        $request->session()->put('uploaded_ex',$name);

        return redirect('nuovo-esercizio-'. request('id'));

    }


    public function cancella_file_sessione_ex(Request $request){
        if($request->session()->exists('uploaded_ex')){
            File::delete(storage_path('/app/private/') . $request->session()->get('uploaded_ex'));
        }
        $request->session()->forget('uploaded_ex');
        return redirect('nuovo-esercizio-'. request('id'));
    }

    public function carica_esercizio(Request $request){
        $id_corso = request('id');

        $titolo = request('titolo');
        $prezzo = request('prezzo');

        $esercizio = new Exercise();

        $esercizio->title = $titolo;
        $esercizio->course_id = $id_corso;
        $esercizio->trace = $request->session()->get('uploaded_trace_ex');
        $esercizio->execution = $request->session()->get('uploaded_ex');
        $esercizio->price = $prezzo;

        $esercizio->save();

        $request->session()->forget('uploaded_trace_ex');
        $request->session()->forget('uploaded_ex');

        return redirect('modifica-dettagli-corso-'. $id_corso);

    }

    public function elimina_esercizio(Request $request){
        $esercizio = Exercise::where('id','=',request('id'))->first();
        File::delete(storage_path('/app/private/') . $esercizio->trace);
        File::delete(storage_path('/app/private/') . $esercizio->execution);
        $esercizio->delete();
        return redirect('modifica-dettagli-corso-'. request('id_corso'));
    }

    public function re_upload_trace_ex(Request $request)
    {
        $id_esercizio = request('id');

        $esercizio = Exercise::where('id','=',$id_esercizio)->first();

        File::delete(storage_path('/app/private/') . $esercizio->trace);

        $file = $request->file('file-trace-ex');
        $name = $file->hashName();
        $file->move(storage_path('/app/private/'),$name);

        $esercizio->trace = $name;

        $esercizio->save();

        return redirect('modifica-esercizio-'. request('id_corso'). '-' . $id_esercizio);

    }

    public function re_upload_ex(Request $request)
    {

        $id_esercizio = request('id');

        $esercizio = Exercise::where('id','=',$id_esercizio)->first();

        File::delete(storage_path('/app/private/') . $esercizio->execution);

        $file = $request->file('file-ex');
        $name = $file->hashName();
        $file->move(storage_path('/app/private/'),$name);

        $esercizio->execution = $name;

        $esercizio->save();

        return redirect('modifica-esercizio-'. request('id_corso'). '-' . $id_esercizio);

    }

    public function modifica_esercizio(Request $request){

        $id_esercizio = request('id_esercizio');
        $titolo = request('titolo');
        $prezzo = request('prezzo');

        $esercizio = Exercise::where('id','=',$id_esercizio)->first();

        $esercizio->title = $titolo;
        $esercizio->price = $prezzo;

        $esercizio->save();

        return redirect('modifica-esercizio-'. request('id_corso'). '-' . $id_esercizio);

    }
}
