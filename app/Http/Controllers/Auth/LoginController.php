<?php

namespace App\Http\Controllers\Auth;

include(app_path('Http/Utility/phpmailer/PHPMailer.php'));
include(app_path('Http/Utility/phpmailer/SMTP.php'));
include(app_path('Http/Utility/phpmailer/Exception.php'));

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Utility\Carrello;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;

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

    public function recupera_password()
    {
        $email = request('email');
        $utente = User::where('email', '=', $email)->first();
        $count = User::where('email', '=', $email)->count();
        if ($count == 0) {
            return back()->withError(
                'Email non presente',
            );
        }
        $pass = LoginController::generaCodice();
        $password = password_hash($pass, PASSWORD_DEFAULT);
        $utente->password = $password;
        $utente->save();
                //invio email
        // Create instance of PHPMailer
        $mail = new PHPMailer();
        // Set mailer to use smtp
        $mail->isSMTP();
        // Define smtp host
        $mail->Host = "smtps.aruba.it";
        // Enable smtp authentication
        $mail->SMTPAuth = true;
        // Set smtp encryption type (ssl/tls)
        $mail->SMTPSecure = "ssl";
        // Port to connect smtp
        $mail->Port = "465";
        // Set gmail username
        $mail->Username = "info@lezioni-informatica.it";
        // Set gmail password
        $mail->Password = "3DWjnkVW.tkez5NS";
        // Email subject
        $mail->Subject = "Recupero Password";
        // Set sender email
        $mail->setFrom('info@lezioni-informatica.it');
        // Enable HTML
        $mail->isHTML(true);
        // Email body
        $mail->Body = "Gentile cliente,<br>la sua password &egrave; stata modificata ed &egrave; la seguente:<br><strong>". $pass . "</strong><br><br><br>Lezioni Informatica";
        // Add recipient
        $mail->addAddress($email);
        // Finally send email
        $mail->send();
        // Closing smtp connection
        $mail->smtpClose();
        return back()->withSuccess('Password modificata');
    }
}
