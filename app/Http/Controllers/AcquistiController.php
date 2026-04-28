<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Utility\ElementoC;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use App\Http\Utility\Carrello;
use App\Services\OrderService;
use App\Services\InvoiceService;
use App\Mail\OrderCompletedMail;
use Illuminate\Support\Facades\Mail;

class AcquistiController extends Controller
{
    public function aggiungi_al_carrello(Request $request)
    {
        $id = (int) request('id');
        $type =  (int) request('type');

        $carrello = $request->session()->get('carrello');

        $elemento = new ElementoC($id, $type);
        $carrello->aggiungi($elemento);

        return match ($type) {
            0 => redirect('/corso/' . Lesson::find($id)->course_id),
            2 => redirect('/corso/' . Exercise::find($id)->course_id),
            1, 4 => redirect('corso-' . $id),
            5 => redirect('/visualizza-richiesta-studente/' . $id),
            default => redirect('/carrello')
        };
    }

    public function rimuovi_dal_carrello(Request $request)
    {
        $carrello = $request->session()->get('carrello');

        $carrello->rimuovi(request('id'), request('type'));

        return redirect('carrello');
    }

    public function process_payment(Request $request)
    {
        $user = $request->user();

        $user->createOrGetStripeCustomer();

        $carrello = $request->session()->get('carrello');

        $tot = $carrello->getTotale() * 100;

        $payment = $user->pay($tot);

        return response()->json([
            'clientSecret' => $payment->client_secret
        ]);
    }

    public function processa_acquisto(
        Request $request,
        OrderService $orderService,
        InvoiceService $invoiceService
    ) {
        DB::beginTransaction();

        try {
            $user = $request->user();

            $studente = Student::where('user_id', $user->id)->first();

            $carrello = $request->session()->get('carrello');

            /*
             * 1. CREA ORDINE + RIGHE
             */
            $orderData = $orderService->process($studente, $carrello);

            /*
             * 2. GENERA PDF (ON DEMAND, via InvoiceService)
             */
            $pdf = $invoiceService->generatePdf(
                $user,
                $studente,
                $orderData['rows'],
                $orderData['total'],
                $orderData['order']
            );

            /*
             * 3. INVIO EMAIL
             */
            Mail::to($user->email)->send(
                new OrderCompletedMail(
                    $user,
                    $pdf,
                    now(),
                    $orderData['total']
                )
            );

            /*
             * 4. SVUOTA CARRELLO
             */
            $carrello->vuotaCarrello();

            DB::commit();

            return redirect('acquisto-a-buon-fine');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function prepara_pagamento()
    {
        $prezzo = request('prezzo');
        $qta = request('qta');

        session()->put('descrizione', request('descrizione'));
        session()->put('prezzo', $prezzo);
        session()->put('qta', $qta);

        if (($prezzo * $qta) > 77.47) {
            return back()->withError('Importo superiore a 77.47 € (max consentito)');
        }

        return redirect('paga');
    }

    public function processa_pagamento_individuale(Request $request)
    {
        $user = $request->user();

        $user->createOrGetStripeCustomer();

        $tot = session()->get('prezzo') * session()->get('qta') * 100;

        $payment = $user->pay($tot);

        return response()->json([
            'clientSecret' => $payment->client_secret
        ]);
    }
}
