<?php

namespace App\Http\Controllers\Public;

include(app_path('Http/Utility/phpmailer/PHPMailer.php'));
include(app_path('Http/Utility/phpmailer/SMTP.php'));
include(app_path('Http/Utility/phpmailer/Exception.php'));
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\LessonOnRequest;
use App\Models\Student;
use PHPMailer\PHPMailer\PHPMailer;
use App\Models\User;

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
        $admin = User::where('role','=','admin')->first();
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
        $mail->Subject = "Nuova Richiesta Studente";
        // Set sender email
        $mail->setFrom('info@lezioni-informatica.it');
        // Enable HTML
        $mail->isHTML(true);
        // Email body
        $mail->Body = "Salve,<br>&egrave; stata inviata una nuova richiesta<br>Controlla il sito!<br><br><br>Lezioni Informatica";
        // Add recipient
        $mail->addAddress($admin->email);
        // Finally send email
        $mail->send();
        // Closing smtp connection
        $mail->smtpClose();

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

        $studente = Student::where('id','=',$lezione->student_id)->first();

        $user = User::where('id','=',$studente->user_id)->first();

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
        $mail->Subject = "Richiesta Evasa";
        // Set sender email
        $mail->setFrom('info@lezioni-informatica.it');
        // Enable HTML
        $mail->isHTML(true);
        // Email body
        $mail->Body = "Gentile Studente,<br>la sua richiesta &egrave; stata evasa<br>Controllare il sito per visualizzare il preventivo<br><br><br>Lezioni Informatica";
        // Add recipient
        $mail->addAddress($user->email);
        // Finally send email
        $mail->send();
        // Closing smtp connection
        $mail->smtpClose();

        return redirect('visualizza-richiesta-'. $id);
    }
}
