<div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold">الفواتير المحفوظة</h1>
                <p class="text-gray-500 text-sm mt-1">عرض جميع الفواتير التي تم إنشاؤها</p>
            </div>
            <a
                href="{{ route('home') }}"
                wire:navigate
                class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-md"
            >
                + فاتورة جديدة
            </a>
        </div>

        @if ($invoices->isEmpty())
            <div class="text-center py-12 text-gray-500">
                <p class="mb-4">لا توجد فواتير محفوظة بعد.</p>
                <a href="{{ route('home') }}" wire:navigate class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    إنشاء أول فاتورة
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right font-medium text-gray-700 border-b">رقم الفاتورة</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-700 border-b">العميل</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-700 border-b">تاريخ الإصدار</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-700 border-b">المجموع الكلي</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-700 border-b">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr class="border-b border-gray-100 hover:bg-gray-50" wire:key="invoice-{{ $invoice->id }}">
                                <td class="px-4 py-3 font-medium">{{ $invoice->invoice_number }}</td>
                                <td class="px-4 py-3">{{ $invoice->customer->name }}</td>
                                <td class="px-4 py-3">{{ $invoice->issue_date->format('Y-m-d') }}</td>
                                <td class="px-4 py-3 font-medium">{{ number_format($invoice->grand_total, 2) }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-3">
                                        <a
                                            href="{{ route('invoices.show', $invoice) }}"
                                            wire:navigate
                                            class="text-blue-600 hover:text-blue-800 font-medium"
                                        >
                                            عرض
                                        </a>
                                        <a
                                            href="{{ route('invoices.pdf', $invoice) }}"
                                            target="_blank"
                                            class="text-gray-600 hover:text-gray-800 font-medium"
                                        >
                                            PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>
</div>
