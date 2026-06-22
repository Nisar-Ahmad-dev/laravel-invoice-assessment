<div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">فاتورة جديدة</h1>
                <p class="text-gray-500 mt-1">إنشاء فاتورة مع حساب تلقائي على الخادم</p>
            </div>
            <div class="flex flex-col items-start md:items-end gap-2">
                <a
                    href="{{ route('invoices.index') }}"
                    wire:navigate
                    class="text-sm text-blue-600 hover:text-blue-800 font-medium"
                >
                    عرض الفواتير المحفوظة
                </a>
                <div class="text-left md:text-right">
                    <p class="text-sm text-gray-500">شركة المثال للتجارة</p>
                    <p class="text-sm text-gray-500">الرياض، المملكة العربية السعودية</p>
                </div>
            </div>
        </div>

        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">العميل</label>
                    <select
                        id="customer_id"
                        wire:model="customer_id"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    >
                        <option value="">اختر العميل</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="issue_date" class="block text-sm font-medium text-gray-700 mb-1">تاريخ الإصدار</label>
                    <input
                        type="date"
                        id="issue_date"
                        wire:model="issue_date"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    >
                    @error('issue_date')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <livewire:add-customer />

            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">ملاحظات</label>
                <textarea
                    id="notes"
                    wire:model="notes"
                    rows="2"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    placeholder="ملاحظات إضافية (اختياري)"
                ></textarea>
            </div>

            <div class="overflow-x-auto mb-4">
                <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-right font-medium text-gray-700 border-b">الوصف</th>
                            <th class="px-3 py-2 text-right font-medium text-gray-700 border-b w-24">الكمية</th>
                            <th class="px-3 py-2 text-right font-medium text-gray-700 border-b w-28">سعر الوحدة</th>
                            <th class="px-3 py-2 text-right font-medium text-gray-700 border-b w-24">الخصم %</th>
                            <th class="px-3 py-2 text-right font-medium text-gray-700 border-b w-24">الضريبة %</th>
                            <th class="px-3 py-2 text-right font-medium text-gray-700 border-b w-28">المجموع</th>
                            <th class="px-3 py-2 text-center font-medium text-gray-700 border-b w-12">حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $index => $item)
                            <tr wire:key="item-{{ $index }}" class="border-b border-gray-100">
                                <td class="px-3 py-2">
                                    <input
                                        type="text"
                                        wire:model.live="items.{{ $index }}.description"
                                        class="w-full rounded border border-gray-300 px-2 py-1 text-sm"
                                        placeholder="وصف البند"
                                    >
                                    @error("items.{$index}.description")
                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td class="px-3 py-2">
                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0.01"
                                        wire:model.live="items.{{ $index }}.quantity"
                                        class="w-full rounded border border-gray-300 px-2 py-1 text-sm"
                                    >
                                    @error("items.{$index}.quantity")
                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td class="px-3 py-2">
                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        wire:model.live="items.{{ $index }}.unit_price"
                                        class="w-full rounded border border-gray-300 px-2 py-1 text-sm"
                                    >
                                    @error("items.{$index}.unit_price")
                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td class="px-3 py-2">
                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        max="100"
                                        wire:model.live="items.{{ $index }}.discount_percent"
                                        class="w-full rounded border border-gray-300 px-2 py-1 text-sm"
                                    >
                                </td>
                                <td class="px-3 py-2">
                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        max="100"
                                        wire:model.live="items.{{ $index }}.tax_percent"
                                        class="w-full rounded border border-gray-300 px-2 py-1 text-sm"
                                    >
                                </td>
                                <td class="px-3 py-2 text-right font-medium text-gray-800 tabular-nums whitespace-nowrap">
                                    {{ number_format($lineTotals[$index]['line_total'] ?? 0, 2) }}
                                </td>
                                <td class="px-3 py-2 text-center align-middle">
                                    @if (count($items) > 2)
                                        <button
                                            type="button"
                                            wire:click.stop="removeRow({{ $index }})"
                                            aria-label="حذف"
                                            title="حذف"
                                            class="inline-flex items-center justify-center p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-between items-start mb-6">
                <button
                    type="button"
                    wire:click="addRow"
                    class="text-sm text-blue-600 hover:text-blue-800 font-medium"
                >
                    + إضافة بند
                </button>

                <div class="w-full max-w-xs space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">المجموع الفرعي</span>
                        <span class="font-medium">{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">إجمالي الخصم</span>
                        <span class="font-medium text-red-600">-{{ number_format($discountTotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">إجمالي الضريبة</span>
                        <span class="font-medium">{{ number_format($taxTotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-200 pt-2 text-base">
                        <span class="font-bold text-gray-900">المجموع الكلي</span>
                        <span class="font-bold text-gray-900">{{ number_format($grandTotal, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-md text-sm transition"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="save">حفظ الفاتورة</span>
                    <span wire:loading wire:target="save">جاري الحفظ...</span>
                </button>
            </div>
        </form>
    </div>
</div>
