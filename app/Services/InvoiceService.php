<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Student;
use Carbon\Carbon;
use Dompdf\Dompdf;

class InvoiceService
{
    public function generatePdf(User $user, Student $studente, array $rows, float $total, Order $order)
    {
        $admin = User::where('role', 'admin')->first();
        $adminData = Admin::where('user_id', $admin->id)->first();

        $number = $this->getNextInvoiceNumber();

        $data = Carbon::now();

        $html = view('invoices.invoice', [
            'user' => $user,
            'studente' => $studente,
            'admin' => $admin,
            'adminData' => $adminData,
            'rows' => $rows,
            'total' => $total,
            'order' => $order,
            'dataFattura' => $data->format('d/m/Y'),
            'numeroFattura' => $number,
        ])->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdf = $dompdf->output();

        // salva record fattura (solo metadata, NON file)
        Invoice::create([
            'number' => $number,
            'date' => $data
        ]);

        return $pdf;
    }

    public function showInvoice(int $id)
    {
        $invoice = Invoice::findOrFail($id);

        $order = $invoice->order;

        $pdf = $this->renderPdf(
            $invoice,
            $order->user,
            $order->studente,
            $order->rows,
            $order->total
        );

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf');
    }

    public function renderPdf(Invoice $invoice, User $user, Student $studente, $rows, $total): string
    {
        $admin = User::where('role', 'admin')->first();
        $adminData = Admin::where('user_id', $admin->id)->first();

        $html = view('invoices.invoice', [
            'user' => $user,
            'studente' => $studente,
            'admin' => $admin,
            'adminData' => $adminData,
            'rows' => $rows,
            'total' => $total,
            'order' => $invoice->order,
            'dataFattura' => $invoice->date->format('d/m/Y'),
            'numeroFattura' => $invoice->number,
        ])->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    public function createInvoiceRecord(Order $order): Invoice
    {
        $number = $this->getNextInvoiceNumber();

        return Invoice::create([
            'order_id' => $order->id,
            'number' => $number,
            'date' => now(),
        ]);
    }

    private function getNextInvoiceNumber(): int
    {
        $last = Invoice::latest()->first();

        if (!$last) {
            return 1;
        }

        $currentYear = now()->year;
        $lastYear = Carbon::parse($last->date)->year;

        if ($currentYear === $lastYear) {
            return $last->number + 1;
        }

        return 1;
    }
}
