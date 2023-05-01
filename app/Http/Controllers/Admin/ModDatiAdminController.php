<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Admin;
use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ModDatiAdminController extends Controller
{

    public function upload_foto(Request $request)
    {

        $user = User::where('email', auth()->user()->email)->first();

        $id = $user->id;

        $admin = Admin::where('user_id',$id)->first();
        if($admin->photo !== null){
            File::delete(base_path('\public'). $admin->photo);
        }
        $file = $request->file('file');
        $name = $file->hashName();
        $file->move(base_path('\public\files\photo_admin'),$name);

        $path = '/files/photo_admin/' . $name;

        $admin->photo = $path;

        $admin->save();

        return redirect('mod-foto-admin');
    }

    public function upload_cert(Request $request)
    {

        $id =  $request->input('id');
        $certificate = Certificate::where('id', $id)->first();

        if($certificate->percorso_file !== null){
            File::delete(base_path('\public'). $certificate->percorso_file);
        }
        $file = $request->file('file_'. $id);
        $name = $file->hashName();
        $file->move(base_path('\public\files\cert_admin'),$name);

        $path = '/files/cert_admin/' . $name;

        $certificate->percorso_file = $path;

        $certificate->save();

        return redirect('mod-certif');
    }

    public function upload_cert_session(Request $request)
    {


        if($request->session()->exists('uploaded_cert')){
            File::delete(base_path('\public'). $request->session()->get('uploaded_cert'));
        }
        $file = $request->file('file');
        $name = $file->hashName();
        $file->move(base_path('\public\files\cert_admin'),$name);

        $path = '/files/cert_admin/' . $name;

        $request->session()->put('uploaded_cert',$path);

        return redirect('aggiungi-certif');
    }

    function modifica_chiave(Request $request){
        $chiave = $request->input('chiave');
        $admin = auth()->user()->admin;

        $admin->stripe_private_key = $chiave;

        $admin->save();

        return redirect('mod-chiave-priv-stripe');
    }

    function modifica_nome_cert(Request $request){
        $id = $request->input('id');
        $nome = $request->input('nome_'. $id);
        $certificate = Certificate::where('id', $id)->first();
        $certificate->nome = $nome;
        $certificate->save();

        return redirect('mod-certif');

    }

    function mod_ind(Request $request){
        $indirizzo = $request->input('inputIndirizzo');
        $numeroCivico =  $request->input('inputNumeroCivico');
        $citta =  $request->input('inputCitta');
        $provincia =  $request->input('inputProvincia');
        $cap =    $request->input('inputCAP');

        $admin = auth()->user()->admin;

        $admin->street = $indirizzo;
        $admin->house_number = $numeroCivico;
        $admin->city = $citta;
        $admin->province = $provincia;
        $admin->postal_code = $cap;

        $admin->save();

        return redirect('mod-indirizzo-admin');
    }

    function elimina_cert(Request $request){

        $id_cert = $request->input('id');
        $certificate = Certificate::where('id', $id_cert)->first();
        File::delete(base_path('\public'. $certificate->percorso_file));
        DB::table('certificates')->where('id','=',$id_cert)->delete();
        return redirect('mod-certif');
    }

    function elimina_cert_session(Request $request){
        if($request->session()->exists('uploaded_cert')){
            File::delete(base_path('\public'). $request->session()->get('uploaded_cert'));
            $request->session()->forget('uploaded_cert');
        }

        return redirect('aggiungi-certif');
    }

    function add_cert_admin(Request $request){
        $nome = $request->input('nome');

        $cert =  new Certificate();
        $cert->nome = $nome;
        $cert->percorso_file =  $request->session()->get('uploaded_cert');
        $request->session()->forget('uploaded_cert');
        $cert->save();

        return redirect('mod-certif');
    }

    function mod_email_admin(Request $request){
        $email = $request->input('inputEmail');
        $user = DB::table('users')->where('email','=',$email)->first();
        if($user != null){
            return back()->withErrors([
                'email' => 'Email già presente',
            ])->onlyInput('email');
        }else{
            $usr = User::where('email','=',auth()->user()->email)->first();
            $usr->email = $email;
            $usr->save();
            return redirect('mod-cred');
        }
    }

    function mod_pass_admin(Request $request){

        $pass_old = password_hash($request->input('inputPassword_old'), PASSWORD_DEFAULT);
        if(Hash::check($pass_old, auth()->user()->password) ){
            return back()->withErrors([
                'pass0' => 'La password non corrisponde  a quella già inserita'
            ]);
        }

        $new_pass = $request->input('inputPassword');
        $confirm_pass = $request->input('inputPassword2');

        $usr = User::where('email','=',auth()->user()->email)->first();

        $usr->password = password_hash($new_pass, PASSWORD_DEFAULT);

        $usr->save();

        return redirect('mod-cred')->withSuccess('Password Modificata con successo');

    }
}
