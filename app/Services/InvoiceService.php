<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function __construct(
        private readonly InvoiceCalculator $calculator,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function store(array $data): Invoice
    {
        $calculation = $this->calculator->calculate($data['items']);

        return DB::transaction(function () use ($data, $calculation) {
            $invoice = Invoice::query()->create([
                'customer_id' => $data['customer_id'],
                'invoice_number' => $this->generateInvoiceNumber(),
                'issue_date' => $data['issue_date'],
                'subtotal' => $calculation['subtotal'],
                'discount_total' => $calculation['discount_total'],
                'tax_total' => $calculation['tax_total'],
                'grand_total' => $calculation['grand_total'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['items'] as $index => $item) {
                $line = $calculation['lines'][$index];

                $invoice->items()->create([
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount_percent' => $item['discount_percent'] ?? 0,
                    'tax_percent' => $item['tax_percent'] ?? 0,
                    'line_subtotal' => $line['line_subtotal'],
                    'line_discount' => $line['line_discount'],
                    'line_tax' => $line['line_tax'],
                    'line_total' => $line['line_total'],
                    'sort_order' => $index,
                ]);
            }

            return $invoice->load(['customer', 'items']);
        });
    }

    private function generateInvoiceNumber(): string
    {
        $date = now()->format('Ymd');
        $prefix = "INV-{$date}-";

        $lastInvoice = Invoice::query()
            ->where('invoice_number', 'like', "{$prefix}%")
            ->orderByDesc('invoice_number')
            ->first();

        $sequence = 1;

        if ($lastInvoice) {
            $lastSequence = (int) substr($lastInvoice->invoice_number, -4);
            $sequence = $lastSequence + 1;
        }

        return $prefix.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
