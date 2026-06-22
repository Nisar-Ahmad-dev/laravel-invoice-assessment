<div class="mb-6">
    @if (! $showForm)
        <button
            type="button"
            wire:click="toggleForm"
            class="text-sm text-green-700 hover:text-green-900 font-medium"
        >
            + إضافة عميل جديد
        </button>
    @else
        <div class="mt-3 p-4 bg-green-50 border border-green-200 rounded-lg">
            <h3 class="text-sm font-semibold text-gray-800 mb-3">إضافة عميل جديد</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">الاسم *</label>
                    <input
                        type="text"
                        wire:model="name"
                        class="w-full rounded border border-gray-300 px-2 py-1.5 text-sm"
                        placeholder="اسم العميل"
                    >
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
                    <input
                        type="email"
                        wire:model="email"
                        class="w-full rounded border border-gray-300 px-2 py-1.5 text-sm"
                        placeholder="email@example.com"
                    >
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">الهاتف</label>
                    <input
                        type="text"
                        wire:model="phone"
                        class="w-full rounded border border-gray-300 px-2 py-1.5 text-sm"
                        placeholder="+966..."
                    >
                    @error('phone')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">العنوان</label>
                    <input
                        type="text"
                        wire:model="address"
                        class="w-full rounded border border-gray-300 px-2 py-1.5 text-sm"
                        placeholder="العنوان"
                    >
                    @error('address')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex gap-2 mt-4">
                <button
                    type="button"
                    wire:click="save"
                    class="bg-green-600 hover:bg-green-700 text-white text-xs font-medium px-4 py-1.5 rounded"
                >
                    حفظ العميل
                </button>
                <button
                    type="button"
                    wire:click="toggleForm"
                    class="text-gray-600 hover:text-gray-800 text-xs font-medium px-4 py-1.5"
                >
                    إلغاء
                </button>
            </div>
        </div>
    @endif
</div>
