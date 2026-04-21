<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Models\LessonOnRequest;
use App\Models\User;
use App\Mail\NuovaRichiestaStudenteMail;
use App\Mail\RichiestaEvasaMail;

class LessonOnRequestController extends Controller
{
    private function filePath($file = null)
    {
        return storage_path('app/private/' . $file);
    }

    private function deleteFile($file = null)
    {
        if ($file && File::exists($this->filePath($file))) {
            File::delete($this->filePath($file));
        }
    }

    private function saveFile($file)
    {
        $name = $file->hashName();
        $file->move(storage_path('app/private'), $name);
        return $name;
    }

    public function add_file_su_richiesta(Request $request)
    {
        $this->deleteFile($request->session()->get('uploaded_lez_rich'));

        $file = $request->file('file');
        $name = $this->saveFile($file);

        $request->session()->put('uploaded_lez_rich', $name);

        return redirect()->route('lezione-su-richiesta');
    }

    public function elimina_lez_rich(Request $request)
    {
        $this->deleteFile($request->session()->get('uploaded_lez_rich'));
        $request->session()->forget('uploaded_lez_rich');

        return redirect()->route('lezione-su-richiesta');
    }

    public function carica_lez_rich(Request $request)
    {
        LessonOnRequest::create([
            'title' => $request->input('titolo'),
            'student_id' => $request->user()->student->id,
            'trace' => $request->session()->get('uploaded_lez_rich'),
        ]);

        $request->session()->forget('uploaded_lez_rich');

        $admin = User::where('role', 'admin')->first();

        Mail::to($admin->email)
            ->send(new NuovaRichiestaStudenteMail());

        return redirect()->route('esito-lez-rich');
    }

    public function sol_rich_upload(Request $request)
    {
        $lezione = LessonOnRequest::findOrFail($request->id);

        $this->deleteFile($lezione->execution);

        $lezione->update([
            'execution' => $this->saveFile($request->file('file'))
        ]);

        return redirect()->route('visualizza-richiesta', $lezione->id);
    }

    public function lez_rich_rem_exec(Request $request)
    {
        $lezione = LessonOnRequest::findOrFail($request->id);

        $this->deleteFile($lezione->execution);

        $lezione->update([
            'execution' => null
        ]);

        return redirect()->route('visualizza-richiesta', $lezione->id);
    }

    public function carica_prezzo_lez_rich(Request $request)
    {
        $lezione = LessonOnRequest::findOrFail($request->id);

        $lezione->update([
            'price' => $request->prezzo,
            'escaped' => 1
        ]);

        $user = $lezione->student->user;

        Mail::to($user->email)
            ->send(new RichiestaEvasaMail());

        return redirect()->route('visualizza-richiesta', $lezione->id);
    }
}
