<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Utility\Carrello;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecuperaPasswordMail;
use Illuminate\Support\Facades\Password;


class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);



        if (Auth::guard('web')->attempt($credentials)) {

            $request->session()->regenerate();

            if ($request->user()->role === 'admin') {
                return redirect('dashboard-admin');
            } elseif ($request->user()->role === 'student') {
                Session::put('carrello', new Carrello());
                if (request('return') === '1') {
                    return redirect('lezione-su-richiesta');
                } else {
                    return redirect('/');
                }
            }
        }

        return back()->withErrors([
            'email' => 'Credenziali non corrette',
        ])->onlyInput('email');
    }

    public static function generaCodice($length = 16)
    {
        $salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $caratteri_speciali = '.@#$!?,;:';
        $maiuscola = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $minuscola = 'abcdefghijklmnopqrstuvwxyz';
        $numero = '0123456789';
        $len = strlen($salt);
        $codiceAtt = '';
        mt_srand(10000000 * (float) microtime());
        for ($i = 0; $i < $length; $i++) {
            $codiceAtt .= $salt[mt_rand(0, $len - 1)];
        }
        $codiceAtt .= $caratteri_speciali[mt_rand(0, strlen($caratteri_speciali) - 1)];
        $codiceAtt .= $maiuscola[mt_rand(0, strlen($maiuscola) - 1)];
        $codiceAtt .= $minuscola[mt_rand(0, strlen($minuscola) - 1)];
        $codiceAtt .= $numero[mt_rand(0, strlen($numero) - 1)];
        return $codiceAtt;
    }

    // public function recupera_password()
    // {
    //     $email = request('email');

    //     $utente = User::where('email', $email)->first();

    //     if (!$utente) {
    //         return back()->withErrors([
    //             'email' => 'Email non presente',
    //         ]);
    //     }

    //     $pass = self::generaCodice();
    //     $utente->password = password_hash($pass, PASSWORD_DEFAULT);
    //     $utente->save();

    //     Mail::to($email)->send(new RecuperaPasswordMail($pass));

    //     return back()->withSuccess('Password modificata e inviata via email');
    // }

    public function recupera_password()
    {
        $status = Password::sendResetLink(
            request()->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->withSuccess('Link di reset inviato via email');
        }

        return back()->withErrors([
            'email' => 'Email non valida o non presente'
        ]);
    }
}
