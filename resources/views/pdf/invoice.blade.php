<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>فاتورة {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: dejavusans, sans-serif;
            font-size: 12px;
            color: #1f2937;
            direction: rtl;
            text-align: right;
        }
        h1 { font-size: 20px; margin: 0 0 4px; }
        .muted { color: #6b7280; }
        .header { margin-bottom: 24px; }
        .section { margin-bottom: 20px; }
        .box {
            background: #f9fafb;
            padding: 12px;
            margin-bottom: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: right;
        }
        th { background: #f3f4f6; }
        .totals { width: 280px; margin-right: auto; margin-left: 0; }
        .totals td { border: none; padding: 4px 8px; }
        .grand-total { font-weight: bold; font-size: 14px; border-top: 1px solid #d1d5db; }
    </style>
</head>
<body>
    <div class="header">
        <h1>فاتورة</h1>
        <p class="muted">رقم الفاتورة: {{ $invoice->invoice_number }}</p>
        <p class="muted">تاريخ الإصدار: {{ $invoice->issue_date->format('Y-m-d') }}</p>
    </div>

    <div class="box section">
        <strong>بيانات العميل</strong><br>
        {{ $invoice->customer->name }}<br>
        @if ($invoice->customer->email) {{ $invoice->customer->email }}<br> @endif
        @if ($invoice->customer->phone) {{ $invoice->customer->phone }}<br> @endif
        @if ($invoice->customer->address) {{ $invoice->customer->address }} @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>الوصف</th>
                <th>الكمية</th>
                <th>سعر الوحدة</th>
                <th>الخصم %</th>
                <th>الضريبة %</th>
                <th>المجموع</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ number_format($item->quantity, 2) }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ number_format($item->discount_percent, 2) }}</td>
                    <td>{{ number_format($item->tax_percent, 2) }}</td>
                    <td>{{ number_format($item->line_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>المجموع الفرعي</td>
            <td>{{ number_format($invoice->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td>إجمالي الخصم</td>
            <td>{{ number_format($invoice->discount_total, 2) }}</td>
        </tr>
        <tr>
            <td>إجمالي الضريبة</td>
            <td>{{ number_format($invoice->tax_total, 2) }}</td>
        </tr>
        <tr class="grand-total">
            <td>المجموع الكلي</td>
            <td>{{ number_format($invoice->grand_total, 2) }}</td>
        </tr>
    </table>

    @if ($invoice->notes)
        <div class="section">
            <strong>ملاحظات:</strong> {{ $invoice->notes }}
        </div>
    @endif
</body>
</html>
