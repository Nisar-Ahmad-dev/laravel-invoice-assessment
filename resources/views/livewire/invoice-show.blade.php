<div>
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold">فاتورة {{ $invoice->invoice_number }}</h1>
                <p class="text-gray-500 text-sm mt-1">تاريخ الإصدار: {{ $invoice->issue_date->format('Y-m-d') }}</p>
            </div>
            <div class="flex gap-3">
                <a
                    href="{{ route('invoices.index') }}"
                    wire:navigate
                    class="inline-flex items-center border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-md"
                >
                    جميع الفواتير
                </a>
                <a
                    href="{{ route('invoices.pdf', $invoice) }}"
                    target="_blank"
                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-md"
                >
                    معاينة PDF
                </a>
                <a
                    href="{{ route('home') }}"
                    wire:navigate
                    class="inline-flex items-center border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-md"
                >
                    فاتورة جديدة
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 p-4 bg-gray-50 rounded-lg">
            <div>
                <h2 class="text-sm font-semibold text-gray-700 mb-2">بيانات العميل</h2>
                <p class="font-medium">{{ $invoice->customer->name }}</p>
                @if ($invoice->customer->email)
                    <p class="text-sm text-gray-600">{{ $invoice->customer->email }}</p>
                @endif
                @if ($invoice->customer->phone)
                    <p class="text-sm text-gray-600">{{ $invoice->customer->phone }}</p>
                @endif
                @if ($invoice->customer->address)
                    <p class="text-sm text-gray-600">{{ $invoice->customer->address }}</p>
                @endif
            </div>
            <div class="text-left md:text-right">
                <h2 class="text-sm font-semibold text-gray-700 mb-2">المبالغ</h2>
                <p class="text-sm"><span class="text-gray-600">المجموع الفرعي:</span> {{ number_format($invoice->subtotal, 2) }}</p>
                <p class="text-sm"><span class="text-gray-600">الخصم:</span> {{ number_format($invoice->discount_total, 2) }}</p>
                <p class="text-sm"><span class="text-gray-600">الضريبة:</span> {{ number_format($invoice->tax_total, 2) }}</p>
                <p class="text-lg font-bold mt-1">المجموع الكلي: {{ number_format($invoice->grand_total, 2) }}</p>
            </div>
        </div>

        <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden mb-6">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-right font-medium border-b">الوصف</th>
                    <th class="px-3 py-2 text-right font-medium border-b">الكمية</th>
                    <th class="px-3 py-2 text-right font-medium border-b">سعر الوحدة</th>
                    <th class="px-3 py-2 text-right font-medium border-b">الخصم</th>
                    <th class="px-3 py-2 text-right font-medium border-b">الضريبة</th>
                    <th class="px-3 py-2 text-right font-medium border-b">المجموع</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr class="border-b border-gray-100">
                        <td class="px-3 py-2">{{ $item->description }}</td>
                        <td class="px-3 py-2">{{ number_format($item->quantity, 2) }}</td>
                        <td class="px-3 py-2">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="px-3 py-2">{{ number_format($item->discount_percent, 2) }}%</td>
                        <td class="px-3 py-2">{{ number_format($item->tax_percent, 2) }}%</td>
                        <td class="px-3 py-2 font-medium">{{ number_format($item->line_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($invoice->notes)
            <div class="text-sm text-gray-600">
                <span class="font-medium text-gray-700">ملاحظات:</span> {{ $invoice->notes }}
            </div>
        @endif
    </div>
</div>
