<?php

namespace App\Http\Controllers\Files;

include app_path('Http/Utility/funzioni.php');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Lesson;
use App\Models\Exercise;
use App\Models\Student;
use App\Http\Utility\Acquisti;
use App\Models\LessonOnRequest;

class FileAccessController extends Controller
{
    public function __invoke(Request $request, $path)
    {
        $path2 = "private/$path";
        if (!Auth::check()) {
            $lezione = Lesson::where('presentation', '=', $path)->first();
            if ($lezione != null) {
                return Storage::response($path2);
            }
            $lezione = Lesson::where('lesson', '=', $path)->first();
            if ($lezione != null && $lezione->price === 0) {
                return Storage::response($path2);
            }

            $esercizio = Exercise::where('trace', '=', $path)->first();
            if ($esercizio != null) {
                return Storage::response($path2);
            }
            $esercizio = Exercise::where('execution', '=', $path)->first();
            if ($esercizio != null && $esercizio->price === 0) {
                return Storage::response($path2);
            }

            abort(404);
        }
        if (Storage::exists($path2)) {
            $user_role = auth()->user()->role;
            if ($user_role === 'admin') {
                return Storage::response($path2);
            } else if ($user_role ===  'student') {
                $studente = auth()->user()->student;
                $lezione = Lesson::where('presentation', '=', $path)->first();
                if ($lezione != null) {
                    return Storage::response($path2);
                }
                $lezione = Lesson::where('lesson', '=', $path)->first();
                if ($lezione != null && $lezione->price === 0) {
                    return Storage::response($path2);
                }
                if ($lezione != null && Acquisti::prodotto_acquistato($studente->id,$lezione->id,0)) {
                    return Storage::response($path2);
                }
                $esercizio = Exercise::where('trace', '=', $path)->first();
                if ($esercizio != null) {
                    return Storage::response($path2);
                }
                $esercizio = Exercise::where('execution', '=', $path)->first();
                if ($esercizio != null && $esercizio->price === 0) {
                    return Storage::response($path2);
                }
                if ($esercizio != null && Acquisti::prodotto_acquistato($studente->id,$esercizio->id,2)) {
                    return Storage::response($path2);
                }
                if($request->session()->exists('uploaded_lez_rich')){
                    return Storage::response($path2);
                }
                $lez_su_rich = LessonOnRequest::where('trace', '=', $path)->first();
                if($lez_su_rich != null){
                    return Storage::response($path2);
                }
                $lez_su_rich = LessonOnRequest::where('execution', '=', $path)->first();
                if($lez_su_rich != null && $lez_su_rich->paid == 1){
                    return Storage::response($path2);
                }
            } else {
                abort(404);
            }
            /*
            if(auth()->user() != null && auth()->user()->name  === 'Admin'){
                return Storage::response($path2);
            }else{
                abort(404);
            */
        }

        abort(404);
    }
}
