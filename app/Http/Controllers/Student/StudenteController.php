<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StudenteController extends Controller
{
    public function mod_indirizzo_stud(Request $request){
        $indirizzo = $request->input('inputIndirizzo');
        $numeroCivico =  $request->input('inputNumeroCivico');
        $citta =  $request->input('inputCitta');
        $provincia =  $request->input('inputProvincia');
        $cap =    $request->input('inputCAP');

        $student = auth()->user()->student;

        $student->street = $indirizzo;
        $student->house_number = $numeroCivico;
        $student->city = $citta;
        $student->province = $provincia;
        $student->postal_code = $cap;

        $student->save();

        return redirect('mod-dati-pers-stud');
    }

    function mod_email_stud(Request $request){
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
            return redirect('mod-cred-stud');
        }
    }

    function mod_pass_stud(Request $request){

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

        return redirect('mod-cred-stud')->withSuccess('Password Modificata con successo');

    }
}
