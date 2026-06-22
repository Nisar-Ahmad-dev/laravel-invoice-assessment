<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\InvoicePdfService;
use Illuminate\Http\Response;

class InvoicePdfController extends Controller
{
    public function __invoke(Invoice $invoice, InvoicePdfService $pdfService): Response
    {
        $invoice->load(['customer', 'items']);

        $content = $pdfService->stream($invoice);

        return response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="invoice-'.$invoice->invoice_number.'.pdf"',
        ]);
    }
}
