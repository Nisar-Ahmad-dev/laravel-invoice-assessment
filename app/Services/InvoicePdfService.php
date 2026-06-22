<?php

namespace App\Services;

use App\Models\Invoice;
use Mpdf\Mpdf;

class InvoicePdfService
{
    public function stream(Invoice $invoice): string
    {
        $html = view('pdf.invoice', [
            'invoice' => $invoice,
        ])->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 16,
            'margin_bottom' => 16,
            'directionality' => 'rtl',
            'autoArabic' => true,
            'autoLangToFont' => true,
            'default_font' => 'dejavusans',
        ]);

        $mpdf->WriteHTML($html);

        return $mpdf->Output('', 'S');
    }
}
