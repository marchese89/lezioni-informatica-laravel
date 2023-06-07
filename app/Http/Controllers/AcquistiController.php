<?php

namespace App\Http\Controllers;

include(app_path('Http/Utility/dompdf/autoload.inc.php'));
include(app_path('Http/Utility/phpmailer/PHPMailer.php'));
include(app_path('Http/Utility/phpmailer/SMTP.php'));
include(app_path('Http/Utility/phpmailer/Exception.php'));
include(app_path('Http/Utility/funzioni.php'));


use Illuminate\Http\Request;
use App\Http\Utility\ElementoC;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Utility\Data;
use App\Models\Admin;
use App\Models\Chat;
use App\Models\Invoice;
use App\Models\InvoiceSheet;
use App\Models\StudentInvoice;
use App\Models\LessonOnRequest;
// Define name spaces
use PHPMailer\PHPMailer\PHPMailer;

use Dompdf\Dompdf;

function prodotto_acquistato($id_studente, $id_prodotto, $tipo_prodotto): bool
{
    $ordini = Order::where('student_id', '=', $id_studente)->all();
    foreach ($ordini as $ordine) {
        $id_ordine = $ordine->id;
        $prodotti_ordine = OrderProduct::where('id_ordine', '=', $id_ordine)->all();
        foreach ($prodotti_ordine as $prodotto) {
            if ($prodotto->id_prodotto === $id_prodotto  && $prodotto->tip_prodotto === $tipo_prodotto) {
                return true;
            }
        }
    }
    return false;
}


class AcquistiController extends Controller
{


    public function aggiungi_al_carrello(Request $request)
    {
        $id = request('id');
        $type = request('type');
        $carrello = $request->session()->get('carrello');
        $elemento =  new ElementoC($id, $type);
        $carrello->aggiungi($elemento);
        if ($type == 0) { //lezione
            $lezione = Lesson::where('id', '=', $id)->first();
            return redirect('corso-' . $lezione->course_id);
        }
        if ($type == 2) { //esercizio
            $esercizio = Exercise::where('id', '=', $id)->first();
            return redirect('corso-' . $esercizio->course_id);
        }
        if ($type == 1 || $type == 4) {
            return  redirect('corso-' . $id);
        }
        if ($type == 5) {
            return  redirect('stud-visualizza-richiesta-' . $id);
        }
    }

    public function rimuovi_dal_carrello(Request $request)
    {
        $id = request('id');
        $type = request('type');
        $carrello = $request->session()->get('carrello');
        $carrello->rimuovi($id, $type);
        return redirect('visualizza-carrello');
    }

    public function process_payment(Request $request)
    {
        $user = $request->user();
        $user->createOrGetStripeCustomer();
        $carrello = $request->session()->get('carrello');
        $tot = $carrello->getTotale();
        $tot = $tot * 100;
        $payment = $user->pay(
            $tot
        );

        $output = [
            'clientSecret' => $payment->client_secret,
        ];

        return json_encode($output);
    }



    public function processa_acquisto(Request $request)
    {
        DB::beginTransaction();
        $user = $request->user();
        $studente = Student::where('user_id', '=', $user->id)->first();
        $admin = User::where('role', '=', 'admin')->first();
        $adminData = Admin::where('user_id', '=', $admin->id)->first();
        $ordine = new Order();
        $ordine->student_id = $studente->id;
        $ordine->save();

        $dompdf = new Dompdf();
        $data = $ordine->date;
        $carbonDate = Carbon::parse($data);
        // Trasforma l'oggetto Carbon in una stringa formattata
        $dateString = $carbonDate->format('Y-m-d H:i:s');
        $data_ = Data::stampa_data($dateString);
        $dataFattura = $data_['giorno'] . '/' . $data_['mese'] . '/' . $data_['anno'];
        $ultimaFattura = Invoice::first();
        $ultimo = $ultimaFattura->number;

        $data_ultima_f = $ultimaFattura->date;
        $data2 = Data::stampa_data($data_ultima_f);
        $numeroFattura  = 1;
        if ($data_['anno'] == $data2['anno']) {
            $numeroFattura = $ultimo + 1;
        }

        $ultimaFattura->delete();
        $nuovaFattura = new Invoice();
        $nuovaFattura->number = $numeroFattura;
        $nuovaFattura->date = $dateString;
        $nuovaFattura->save();


        $html = '
<table width="100%" cellspacing="0" cellpadding="0"
		align="center"
		style="border-collapse: collapse;"
		RULES=none FRAME=none border="0">
<tr style="height:100px">
<td align="center" colspan="3">
<h1>Fattura</h1>
</td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >' . $admin->name . ' ' . $admin->surname . '</font>
</td>
<td></td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >' . $adminData->street . ', ' . $adminData->house_number . '</font>
</td>

<td></td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >' . $adminData->postal_code . ' - ' . $adminData->city . ' (' . $adminData->province . ')</font>
</td>

<td></td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >PARTITA IVA:&nbsp;' . $adminData->piva . '</font>
</td>

<td></td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >COD. FISC: ' . $adminData->cf . '</font>
</td>

<td></td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<h2>Cliente</h2>
</td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<font size=4 >' . $user->name . '&nbsp;' . $user->surname . '</font>
</td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<font size=4 >' . $studente->street . ',' . $studente->house_number . '</font>
</td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<font size=4 >' . $studente->postal_code . ' - ' . $studente->city . '&nbsp;(' . $studente->province . ')</font>
</td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<font size=4 >CF:&nbsp;' .  $studente->cf . '</font>
</td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 ><b>DATA: </b></font>' .
            $dataFattura
            . '</td>

<td></td>
</tr>
<tr style="height:100px">
<td align="left" style="vertical-align:top">
<font size=4 ><b>FATTURA: </b></font>' .
            $numeroFattura . '</td>

<td></td>
</tr>
<tr>


<td align="left" colspan="2">
<table  rules="all" border="1" align="right" style="width:100%" >
<tr style="height:50px">

<td align="center">
<font size=4 ><b>&nbsp;DESCRIZIONE&nbsp;</b></font>
</td>
<td align="center">
<font size=4 ><b>&nbsp;PREZZO&nbsp;</b></font>
</td>
<td align="center">
<font size=4 ><b>&nbsp;QTA&nbsp;</b></font>
</td>
<td align="center">
<font size=4 ><b>&nbsp;IMPORTO&nbsp;</b></font>
</td>
</tr>';


        $id_ordine = $ordine->id;

        $contenuto = $request->session()->get('carrello')->contenuto();
        $prezzo_totale = 0;
        for ($i = 0; $i < count($contenuto); $i++) {
            $elem = $contenuto[$i];
            $tipo = $elem->getTipoElemento();
            $id = $elem->getId();
            switch ($tipo) {
                case 0: // lezione

                    $lezione = Lesson::where('id', '=', $id)->first();
                    $prezzo = $lezione->price;
                    $prodottoOrdine = new OrderProduct();
                    $prodottoOrdine->id_ordine = $id_ordine;
                    $prodottoOrdine->id_prodotto = $id;
                    $prodottoOrdine->tipo_prodotto = $tipo;
                    $prodottoOrdine->price = $prezzo;

                    $prodottoOrdine->save();

                    $chat = new Chat();

                    $chat->id_prodotto = $id;
                    $chat->tipo_prodotto = $tipo;
                    $chat->id_studente = $studente->id;
                    $chat->save();

                    $html = $html . '<tr><td align="center">
            <font size=4 >Lezione:&nbsp;' . $lezione->title . '</font>
            </td>
            <td align="center">
            <font size=4 >' . $lezione->price . '&euro;</font>
            </td>
            <td align="center">
            <font size=4 >1</font>
            </td>
            <td align="center">
            <font size=4 ><b>' . $lezione->price . '&euro;</b></font></td>
            </tr>';
                    $prezzo_totale = $prezzo_totale + $lezione->price;
                    break;
                case 1: // tutte le lezioni di un corso
                    $lezioni = Lesson::where('course_id', '=', $id)->all();
                    foreach ($lezioni as $lez) {
                        $id_lez = $lez->id;
                        $prezzo = $lez->price;
                        if (!prodotto_acquistato($studente->id, $id_lez, 0)) {

                            $prodottoOrdine = new OrderProduct();
                            $prodottoOrdine->id_ordine = $id_ordine;
                            $prodottoOrdine->id_prodotto = $id_lez;
                            $prodottoOrdine->tipo_prodotto = 0;
                            $prodottoOrdine->price = $prezzo;

                            $prodottoOrdine->save();

                            $chat = new Chat();

                            $chat->id_prodotto = $id_lez;
                            $chat->tipo_prodotto = 0;
                            $chat->id_studente = $studente->id;
                            $chat->save();

                            $html = $html . '<tr><td align="center">
            <font size=4 >Lezione:&nbsp;' . $lez->title . '</font>
            </td>
            <td align="center">
            <font size=4 >' . $lez->price . '&euro;</font>
            </td>
            <td align="center">
            <font size=4 >1</font>
            </td>
            <td align="center">
            <font size=4 ><b>' . $lez->price . '&euro;</b></font></td>
            </tr>';
                            $prezzo_totale = $prezzo_totale + $lez->price;
                        }
                    }

                    break;
                case 2: // esercizio
                    $esercizio = Exercise::where('id', '=', $id)->first();
                    $prezzo = $esercizio->price;
                    $prodottoOrdine = new OrderProduct();
                    $prodottoOrdine->id_ordine = $id_ordine;
                    $prodottoOrdine->id_prodotto = $id;
                    $prodottoOrdine->tipo_prodotto = $tipo;
                    $prodottoOrdine->price = $prezzo;

                    $prodottoOrdine->save();

                    $chat = new Chat();

                    $chat->id_prodotto = $id;
                    $chat->tipo_prodotto = $tipo;
                    $chat->id_studente = $studente->id;
                    $chat->save();


                    $html = $html . '<tr><td align="center">
            <font size=4 >Esercizio:&nbsp;' . $esercizio->title . '</font>
            </td>
            <td align="center">
            <font size=4 >' . $esercizio->price . '&euro;</font>
            </td>
            <td align="center">
            <font size=4 >1</font>
            </td>
            <td align="center">
            <font size=4 ><b>' . $esercizio->price . '&euro;</b></font></td>
            </tr>';
                    $prezzo_totale = $prezzo_totale + $esercizio->price;
                    break;
                case 3: // tutti gli esercizi di un corso
                    $esercizi = Exercise::where('course_id', '=', $id)->all();
                    foreach ($esercizi as $ex) {
                        $id_ex = $ex->id;
                        $prezzo = $ex->price;
                        if (!prodotto_acquistato($studente->id, $id_ex, 2)) {
                            $prodottoOrdine = new OrderProduct();
                            $prodottoOrdine->id_ordine = $id_ordine;
                            $prodottoOrdine->id_prodotto = $id_ex;
                            $prodottoOrdine->tipo_prodotto = 2;
                            $prodottoOrdine->price = $prezzo;

                            $prodottoOrdine->save();

                            $chat = new Chat();

                            $chat->id_prodotto = $id_ex;
                            $chat->tipo_prodotto = 2;
                            $chat->id_studente = $studente->id;
                            $chat->save();

                            $html = $html . '<tr><td align="center">
            <font size=4 >Esercizio:&nbsp;' . $ex->title . '</font>
            </td>
            <td align="center">
            <font size=4 >' . $ex->price . '&euro;</font>
            </td>
            <td align="center">
            <font size=4 >1</font>
            </td>
            <td align="center">
            <font size=4 ><b>' . $ex->price . '&euro;</b></font></td>
            </tr>';
                            $prezzo_totale = $prezzo_totale + $ex->price;
                        }
                    }

                    break;
                case 4: // tutte le lezioni e tutti gli esercizi di un corso

                    $lezioni = Lesson::where('course_id', '=', $id)->all();
                    foreach ($lezioni as $lez) {
                        $id_lez = $lez->id;
                        $prezzo = $lez->price;
                        if (!prodotto_acquistato($studente->id, $id_lez, 0)) {
                            $prodottoOrdine = new OrderProduct();
                            $prodottoOrdine->id_ordine = $id_ordine;
                            $prodottoOrdine->id_prodotto = $id_lez;
                            $prodottoOrdine->tipo_prodotto = 0;
                            $prodottoOrdine->price = $prezzo;

                            $prodottoOrdine->save();

                            $chat = new Chat();

                            $chat->id_prodotto = $id;
                            $chat->tipo_prodotto = 0;
                            $chat->id_studente = $studente->id;
                            $chat->save();

                            $html = $html . '<tr><td align="center">
            <font size=4 >Lezione:&nbsp;' . $lez->title . '</font>
            </td>
            <td align="center">
            <font size=4 >' . $lez->price . '&euro;</font>
            </td>
            <td align="center">
            <font size=4 >1</font>
            </td>
            <td align="center">
            <font size=4 ><b>' . $lez->price . '&euro;</b></font></td>
            </tr>';
                            $prezzo_totale = $prezzo_totale + $lez->price;
                        }
                    }

                    $esercizi = Exercise::where('course_id', '=', $id)->all();
                    foreach ($esercizi as $ex) {
                        $id_ex = $ex->id;
                        $prezzo = $ex->price;
                        if (!prodotto_acquistato($studente->id, $id_ex, 2)) {
                            $prodottoOrdine = new OrderProduct();
                            $prodottoOrdine->id_ordine = $id_ordine;
                            $prodottoOrdine->id_prodotto = $id_ex;
                            $prodottoOrdine->tipo_prodotto = 2;
                            $prodottoOrdine->price = $prezzo;

                            $prodottoOrdine->save();

                            $chat = new Chat();

                            $chat->id_prodotto = $id_ex;
                            $chat->tipo_prodotto = 2;
                            $chat->id_studente = $studente->id;
                            $chat->save();

                            $html = $html . '<tr><td align="center">
            <font size=4 >Esercizio:&nbsp;' . $ex->title . '</font>
            </td>
            <td align="center">
            <font size=4 >' . $ex->price . '&euro;</font>
            </td>
            <td align="center">
            <font size=4 >1</font>
            </td>
            <td align="center">
            <font size=4 ><b>' . $ex->price . '&euro;</b></font></td>
            </tr>';
                            $prezzo_totale = $prezzo_totale + $ex->price;
                        }
                    }

                    break;
                case 5:
                    $richiesta = LessonOnRequest::where('id', '=', $id)->first();
                    $richiesta->paid = 1;
                    $richiesta->save();

                    $prezzo = $richiesta->price;
                    $html = $html . '<tr><td align="center">
            <font size=4 >Lezione/Esercizio su richiesta:&nbsp;' . $richiesta->title . '</font>
            </td>
            <td align="center">
            <font size=4 >' . $prezzo . '&euro;</font>
            </td>
            <td align="center">
            <font size=4 >1</font>
            </td>
            <td align="center">
            <font size=4 ><b>' . $prezzo . '&euro;</b></font></td>
            </tr>';
                    $prezzo_totale = $prezzo_totale + $richiesta->price;
                    $prodottoOrdine = new OrderProduct();
                    $prodottoOrdine->id_ordine = $id_ordine;
                    $prodottoOrdine->id_prodotto = $id;
                    $prodottoOrdine->tipo_prodotto = 5;
                    $prodottoOrdine->price = $prezzo;

                    $prodottoOrdine->save();

                    $chat = new Chat();

                    $chat->id_prodotto = $id;
                    $chat->tipo_prodotto = 5;
                    $chat->id_studente = $studente->id;
                    $chat->save();

                    $prezzo_totale = $prezzo_totale + $richiesta['prezzo'];
                    break;
                default:
                    break;
            }
        }
        $html = $html . '
            </table>
            </td>
            </tr>
            <tr style="height:50px">
<td></td>

<td align="right">
<font size=3 >IMPONIBILE:&nbsp; </font>
<font size=3 >' . number_format($prezzo_totale / 1.04, 2, '.', '') . '&nbsp;&euro;</font>
</td>
</tr>
<tr style="height:50px">
<td></td>

<td align="right">
<font size=3 >Rivalsa Inps 4%:&nbsp;</font>
<font size=3 >' . number_format(($prezzo_totale / 1.04) * 4 / 100, 2, '.', '') . '&nbsp;&euro;</font>
</td>
</tr>
<tr style="height:50px">
<td></td>

<td align="right">
<font size=3 ><b>TOTALE</b>&nbsp;</font>
<font size=3 ><b>' . $prezzo_totale . '&nbsp;&euro;</b></font>
</td>
</tr>
<tr>
<td>
<font size=3 >Imposta di bollo &euro; 2,00 su originale</font>
</td>
<td>
</td>
</tr>
<tr>
<td>
<font size=3 >su Importi superiori ad &euro; 77,47</font>
</td>
<td>
</td>
</tr>
<tr>
<td>
<font size=3 ><b>NOTE</b></font>
</td>
<td>
</td>
</tr>
<tr>
<td>
<font size=3 >Pagamento online tramite Carta di Credito</font>
</td>
<td>
</td>
</tr>
<tr align="center" style="height:200px" >
<td colspan="2">
<font size=3 >&nbsp;</font>
</td>
</tr>
<tr align="center">
<td colspan="2">
<font size=3 ><b>Operazione in franchigia da Iva art. 1 cc. 54-89 L. 190/2014 –</b></font>
</td>
</tr>
<tr align="center">
<td colspan="2">
<font size=3 ><b>Non soggetta a ritenuta d’acconto ai sensi del c. 67 L. 190/2014</b></font>
</td>
</tr>
</table>
';

        $number = 1;
        while (file_exists(storage_path('/app/private/') . $number . '.pdf')) {
            $number++;
        }

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portait');
        $dompdf->render();

        $pdf = $dompdf->output();
        file_put_contents(storage_path('/app/private/') . $number . '.pdf', $pdf);
        $percorso_fattura = $number . '.pdf';
        $ordine->invoice = $percorso_fattura;
        $ordine->save();

        $fattura = new InvoiceSheet();
        $fattura->file = $percorso_fattura;
        $fattura->save();

        $fattura_studente = new StudentInvoice();
        $fattura_studente->student_id = $studente->id;
        $fattura_studente->invoice_id = $fattura->id;
        $fattura_studente->save();

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
        $mail->Subject = "Ordine Effettuato";
        // Set sender email
        $mail->setFrom('info@lezioni-informatica.it');
        // Enable HTML
        $mail->isHTML(true);
        // Attachment
        $mail->addAttachment(storage_path('/app/private/') . $number . '.pdf', $number . '.pdf', 'base64', 'application/pdf');
        // Email body
        $mail->Body = "Gentile cliente,<br>Il suo ordine &egrave; andato a buon fine.<br>Fattura in allegato.<br><br><br>Lezioni Informatica";
        // Add recipient
        $mail->addAddress($user->email);
        // Finally send email
        $mail->send();
        // Closing smtp connection
        $mail->smtpClose();
        $request->session()->get('carrello')->vuotaCarrello();

        DB::commit();

        return redirect('acquisto-a-buon-fine');
    }

    public function crea_fattura()
    {
        $nome = request('inputNome');
        $cognome = request('inputCognome');
        $indirizzo = request('inputIndirizzo');
        $numero_civico =  request('inputNumeroCivico');
        $citta =  request('inputCitta');
        $provincia = request('inputProvincia');
        $cap = request('inputCAP');
        $cf = request('inputCF');
        $descrizione = request('descrizione');
        $prezzo =  request('prezzo');
        $qta = request('qta');
        $note = request('note');
        $carbonDate = Carbon::now()->toDateString(); //Carbon::parse($data);
        // Trasforma l'oggetto Carbon in una stringa formattata
        $data_ = Data::stampa_data($carbonDate);
        $dataFattura = $data_['giorno'] . '/' . $data_['mese'] . '/' . $data_['anno'];
        $ultimaFattura = Invoice::first();
        $ultimo = $ultimaFattura->number;

        $data_ultima_f = $ultimaFattura->date;
        $data2 = Data::stampa_data($data_ultima_f);
        $numeroFattura  = 1;
        if ($data_['anno'] == $data2['anno']) {
            $numeroFattura = $ultimo + 1;
        }
        $admin = User::where('role', '=', 'admin')->first();
        $adminData = Admin::where('user_id', '=', $admin->id)->first();
        $html = '
<table width="100%" cellspacing="0" cellpadding="0"
		align="center"
		style="border-collapse: collapse;"
		RULES=none FRAME=none border="0">
<tr style="height:100px">
<td align="center" colspan="3">
<h1>Fattura</h1>
</td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >' . $admin->name . ' ' . $admin->surname . '</font>
</td>
<td></td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >' . $adminData->street . ', ' . $adminData->house_number . '</font>
</td>

<td></td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >' . $adminData->postal_code . ' - ' . $adminData->city . ' (' . $adminData->province . ')</font>
</td>

<td></td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >PARTITA IVA:&nbsp;' . $adminData->piva . '</font>
</td>

<td></td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >COD. FISC: ' . $adminData->cf . '</font>
</td>

<td></td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<h2>Cliente</h2>
</td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<font size=4 >' . $nome . '&nbsp;' . $cognome . '</font>
</td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<font size=4 >' . $indirizzo . ',' . $numero_civico . '</font>
</td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<font size=4 >' . $cap . ' - ' . $citta . '&nbsp;(' . $provincia . ')</font>
</td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<font size=4 >CF:&nbsp;' .  $cf . '</font>
</td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 ><b>DATA: </b></font>' .
            $dataFattura
            . '</td>

<td></td>
</tr>
<tr style="height:100px">
<td align="left" style="vertical-align:top">
<font size=4 ><b>FATTURA: </b></font>' .
            $numeroFattura . '</td>

<td></td>
</tr>
<tr>


<td align="left" colspan="2">
<table  rules="all" border="1" align="right" style="width:100%" >
<tr style="height:50px">

<td align="center">
<font size=4 ><b>&nbsp;DESCRIZIONE&nbsp;</b></font>
</td>
<td align="center">
<font size=4 ><b>&nbsp;PREZZO&nbsp;</b></font>
</td>
<td align="center">
<font size=4 ><b>&nbsp;QTA&nbsp;</b></font>
</td>
<td align="center">
<font size=4 ><b>&nbsp;IMPORTO&nbsp;</b></font>
</td>
</tr>';

        $importo = $prezzo * $qta;


        $html = $html . '<tr><td align="center">
            <font size=4 >' . $descrizione . '</font>
            </td>
            <td align="center">
            <font size=4 >' . $prezzo . '&euro;</font>
            </td>
            <td align="center">
            <font size=4 >' . $qta . '</font>
            </td>
            <td align="center">
            <font size=4 ><b>' . $importo . '&euro;</b></font></td>
            </tr>';


        $html = $html . '
            </table>
            </td>
            </tr>
            <tr style="height:50px">
<td></td>

<td align="right">
<font size=3 >IMPONIBILE:&nbsp; </font>
<font size=3 >' . number_format($importo / 1.04, 2, '.', '') . '&nbsp;&euro;</font>
</td>
</tr>
<tr style="height:50px">
<td></td>

<td align="right">
<font size=3 >Rivalsa Inps 4%:&nbsp;</font>
<font size=3 >' . number_format(($importo / 1.04) * 4 / 100, 2, '.', '') . '&nbsp;&euro;</font>
</td>
</tr>
<tr style="height:50px">
<td></td>

<td align="right">
<font size=3 ><b>TOTALE</b>&nbsp;</font>
<font size=3 ><b>' . $importo . '&nbsp;&euro;</b></font>
</td>
</tr>
<tr>
<td>
<font size=3 >Imposta di bollo &euro; 2,00 su originale</font>
</td>
<td>
</td>
</tr>
<tr>
<td>
<font size=3 >su Importi superiori ad &euro; 77,47</font>
</td>
<td>
</td>
</tr>
<tr>
<td>
<font size=3 ><b>NOTE</b></font>
</td>
<td>
</td>
</tr>
<tr>
<td>
<font size=3 >' . $note . '</font>
</td>
<td>
</td>
</tr>
<tr align="center" style="height:200px" >
<td colspan="2">
<font size=3 >&nbsp;</font>
</td>
</tr>
<tr align="center">
<td colspan="2">
<font size=3 ><b>Operazione in franchigia da Iva art. 1 cc. 54-89 L. 190/2014 –</b></font>
</td>
</tr>
<tr align="center">
<td colspan="2">
<font size=3 ><b>Non soggetta a ritenuta d’acconto ai sensi del c. 67 L. 190/2014</b></font>
</td>
</tr>
</table>
';
        $number = 1;
        while (file_exists(storage_path('/app/private/') . $number . '.pdf')) {
            $number++;
        }
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portait');
        $dompdf->render();

        $pdf = $dompdf->output();
        file_put_contents(storage_path('/app/private/') . $number . '.pdf', $pdf);
        $percorso_fattura = $number . '.pdf';
        $fattura = new InvoiceSheet();
        $fattura->file = $percorso_fattura;
        $fattura->save();
        return redirect('fattura-creata');
    }

    public function prepara_pagamento()
    {
        session()->put('descrizione', request('descrizione'));
        session()->put('prezzo', request('prezzo'));
        session()->put('qta', request('qta'));
        if ((request('prezzo') * request('qta')) > 77.47) {
            return back()->withError(
                'Importo superiore a 77.47 € (max consentito)'
            );
        } else {
            return redirect('paga');
        }
    }

    public function processa_pagamento(Request $request)
    {
        $user = $request->user();
        $user->createOrGetStripeCustomer();
        $tot = session()->get('prezzo') * session()->get('qta') * 100;
        $payment = $user->pay(
            $tot
        );

        $output = [
            'clientSecret' => $payment->client_secret,
        ];

        return json_encode($output);
    }

    public function acquisto(Request $request)
    {
        $user = $request->user();
        $studente = Student::where('user_id', '=', $user->id)->first();
        $nome = $user->name;
        $cognome = $user->surname;
        $indirizzo = $studente->street;
        $numero_civico = $studente->house_number;
        $citta = $studente->city;
        $provincia = $studente->province;
        $cap = $studente->postal_code;
        $cf = $studente->cf;
        $descrizione = session()->get('descrizione');
        $prezzo =  session()->get('prezzo');
        $qta = session()->get('qta');

        $carbonDate = Carbon::now()->toDateString(); //Carbon::parse($data);
        // Trasforma l'oggetto Carbon in una stringa formattata
        $data_ = Data::stampa_data($carbonDate);
        $dataFattura = $data_['giorno'] . '/' . $data_['mese'] . '/' . $data_['anno'];
        $ultimaFattura = Invoice::first();
        $ultimo = $ultimaFattura->number;

        $data_ultima_f = $ultimaFattura->date;
        $data2 = Data::stampa_data($data_ultima_f);
        $numeroFattura  = 1;
        if ($data_['anno'] == $data2['anno']) {
            $numeroFattura = $ultimo + 1;
        }
        $admin = User::where('role', '=', 'admin')->first();
        $adminData = Admin::where('user_id', '=', $admin->id)->first();
        $html = '
<table width="100%" cellspacing="0" cellpadding="0"
		align="center"
		style="border-collapse: collapse;"
		RULES=none FRAME=none border="0">
<tr style="height:100px">
<td align="center" colspan="3">
<h1>Fattura</h1>
</td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >' . $admin->name . ' ' . $admin->surname . '</font>
</td>
<td></td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >' . $adminData->street . ', ' . $adminData->house_number . '</font>
</td>

<td></td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >' . $adminData->postal_code . ' - ' . $adminData->city . ' (' . $adminData->province . ')</font>
</td>

<td></td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >PARTITA IVA:&nbsp;' . $adminData->piva . '</font>
</td>

<td></td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 >COD. FISC: ' . $adminData->cf . '</font>
</td>

<td></td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<h2>Cliente</h2>
</td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<font size=4 >' . $nome . '&nbsp;' . $cognome . '</font>
</td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<font size=4 >' . $indirizzo . ',' . $numero_civico . '</font>
</td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<font size=4 >' . $cap . ' - ' . $citta . '&nbsp;(' . $provincia . ')</font>
</td>
</tr>
<tr style="height:30px">
<td></td>

<td align="right">
<font size=4 >CF:&nbsp;' .  $cf . '</font>
</td>
</tr>
<tr style="height:30px">
<td align="left">
<font size=4 ><b>DATA: </b></font>' .
            $dataFattura
            . '</td>

<td></td>
</tr>
<tr style="height:100px">
<td align="left" style="vertical-align:top">
<font size=4 ><b>FATTURA: </b></font>' .
            $numeroFattura . '</td>

<td></td>
</tr>
<tr>


<td align="left" colspan="2">
<table  rules="all" border="1" align="right" style="width:100%" >
<tr style="height:50px">

<td align="center">
<font size=4 ><b>&nbsp;DESCRIZIONE&nbsp;</b></font>
</td>
<td align="center">
<font size=4 ><b>&nbsp;PREZZO&nbsp;</b></font>
</td>
<td align="center">
<font size=4 ><b>&nbsp;QTA&nbsp;</b></font>
</td>
<td align="center">
<font size=4 ><b>&nbsp;IMPORTO&nbsp;</b></font>
</td>
</tr>';

        $importo = $prezzo * $qta;


        $html = $html . '<tr><td align="center">
            <font size=4 >' . $descrizione . '</font>
            </td>
            <td align="center">
            <font size=4 >' . $prezzo . '&euro;</font>
            </td>
            <td align="center">
            <font size=4 >' . $qta . '</font>
            </td>
            <td align="center">
            <font size=4 ><b>' . $importo . '&euro;</b></font></td>
            </tr>';


        $html = $html . '
            </table>
            </td>
            </tr>
            <tr style="height:50px">
<td></td>

<td align="right">
<font size=3 >IMPONIBILE:&nbsp; </font>
<font size=3 >' . number_format($importo / 1.04, 2, '.', '') . '&nbsp;&euro;</font>
</td>
</tr>
<tr style="height:50px">
<td></td>

<td align="right">
<font size=3 >Rivalsa Inps 4%:&nbsp;</font>
<font size=3 >' . number_format(($importo / 1.04) * 4 / 100, 2, '.', '') . '&nbsp;&euro;</font>
</td>
</tr>
<tr style="height:50px">
<td></td>

<td align="right">
<font size=3 ><b>TOTALE</b>&nbsp;</font>
<font size=3 ><b>' . $importo . '&nbsp;&euro;</b></font>
</td>
</tr>
<tr>
<td>
<font size=3 >Imposta di bollo &euro; 2,00 su originale</font>
</td>
<td>
</td>
</tr>
<tr>
<td>
<font size=3 >su Importi superiori ad &euro; 77,47</font>
</td>
<td>
</td>
</tr>
<tr>
<td>
<font size=3 ><b>NOTE</b></font>
</td>
<td>
</td>
</tr>
<tr>
<td>
<font size=3 >Pagamento online tramite Carta di Credito</font>
</td>
<td>
</td>
</tr>
<tr align="center" style="height:200px" >
<td colspan="2">
<font size=3 >&nbsp;</font>
</td>
</tr>
<tr align="center">
<td colspan="2">
<font size=3 ><b>Operazione in franchigia da Iva art. 1 cc. 54-89 L. 190/2014 –</b></font>
</td>
</tr>
<tr align="center">
<td colspan="2">
<font size=3 ><b>Non soggetta a ritenuta d’acconto ai sensi del c. 67 L. 190/2014</b></font>
</td>
</tr>
</table>
';
        $number = 1;
        while (file_exists(storage_path('/app/private/') . $number . '.pdf')) {
            $number++;
        }
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portait');
        $dompdf->render();

        $pdf = $dompdf->output();
        file_put_contents(storage_path('/app/private/') . $number . '.pdf', $pdf);
        $percorso_fattura = $number . '.pdf';
        $fattura = new InvoiceSheet();
        $fattura->file = $percorso_fattura;
        $fattura->save();

        $fattura_studente = new StudentInvoice();
        $fattura_studente->student_id = $studente->id;
        $fattura_studente->invoice_sheet_id = $fattura->id;
        $fattura_studente->save();

        session()->forget('descrizione');
        session()->forget('prezzo');
        session()->forget('qta');

        return redirect('pagamento-ok');
    }
}
