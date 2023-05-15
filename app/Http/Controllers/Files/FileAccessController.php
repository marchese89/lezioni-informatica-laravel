<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Lesson;
use App\Models\Exercise;

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
