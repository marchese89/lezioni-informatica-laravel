<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

function generaCodice($length = 6)
{
    $salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ012345678';
    $len = strlen($salt);
    $codiceAtt = '';
    mt_srand(10000000 * (double) microtime());
    for ($i = 0; $i < $length; $i ++) {
        $codiceAtt .= $salt[mt_rand(0, $len - 1)];
    }
    return $codiceAtt;
}

class RegistrazioneController extends Controller
{
    public function carica_utente(){


        $nome = request('inputNome');
        $cognome = request('inputCognome');
        $email = request('inputEmail');
        $password = password_hash(request('inputPassword'), PASSWORD_DEFAULT);

        $user_ok = DB::table('users')->where('email', $email)->count();

        if($user_ok == 1){
            return redirect('registrazione_no');
        }

        $user = new User();
        $user->name = $nome;
        $user->surname = $cognome;
        $user->activation_code = generaCodice();
        $user->remember_token = Str::random(10);
        //$user->last_access
        $user->email = $email;
        $user->password = $password;

        $user->save();

        $user2 = DB::table('users')->where('email', $email)->first();

        $indirizzo = request('inputIndirizzo');
        $numeroCivico = request('inputNumeroCivico');
        $citta = request('inputCitta');
        $provincia = request('inputProvincia');
        $cap = request('inputCAP');
        $cf = request('inputCF');

        $student = new Student();
        $student->user_id = $user2->id;
        $student->street = $indirizzo;
        $student->house_number = $numeroCivico;
        $student->city = $citta;
        $student->province = $provincia;
        $student->postal_code = $cap;
        $student->cf = $cf;
        $student->remember_token = Str::random(10);

        $student->save();

        return redirect('registrazione_ok');
    }
}

