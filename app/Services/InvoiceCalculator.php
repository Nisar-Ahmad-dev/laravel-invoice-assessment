<?php

namespace App\Services;

class InvoiceCalculator
{
    /**
     * @param  array<int, array<string, mixed>>  $items
     * @return array{
     *     lines: array<int, array<string, float>>,
     *     subtotal: float,
     *     discount_total: float,
     *     tax_total: float,
     *     grand_total: float
     * }
     */
    public function calculate(array $items): array
    {
        $lines = [];
        $subtotal = 0.0;
        $discountTotal = 0.0;
        $taxTotal = 0.0;
        $grandTotal = 0.0;

        foreach ($items as $index => $item) {
            $quantity = (float) ($item['quantity'] ?? 0);
            $unitPrice = (float) ($item['unit_price'] ?? 0);
            $discountPercent = (float) ($item['discount_percent'] ?? 0);
            $taxPercent = (float) ($item['tax_percent'] ?? 0);

            $lineSubtotal = round($quantity * $unitPrice, 2);
            $lineDiscount = round($lineSubtotal * ($discountPercent / 100), 2);
            $taxable = round($lineSubtotal - $lineDiscount, 2);
            $lineTax = round($taxable * ($taxPercent / 100), 2);
            $lineTotal = round($taxable + $lineTax, 2);

            $lines[$index] = [
                'line_subtotal' => $lineSubtotal,
                'line_discount' => $lineDiscount,
                'line_tax' => $lineTax,
                'line_total' => $lineTotal,
            ];

            $subtotal += $lineSubtotal;
            $discountTotal += $lineDiscount;
            $taxTotal += $lineTax;
            $grandTotal += $lineTotal;
        }

        return [
            'lines' => $lines,
            'subtotal' => round($subtotal, 2),
            'discount_total' => round($discountTotal, 2),
            'tax_total' => round($taxTotal, 2),
            'grand_total' => round($grandTotal, 2),
        ];
    }
}
