<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Services\InvoiceCalculator;
use App\Services\InvoiceService;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class InvoiceForm extends Component
{
    #[Validate('required|exists:customers,id')]
    public ?int $customer_id = null;

    #[Validate('required|date')]
    public string $issue_date;

    #[Validate('nullable|string|max:1000')]
    public ?string $notes = null;

    #[Validate([
        'items' => 'required|array|min:2',
        'items.*.description' => 'required|string|max:255',
        'items.*.quantity' => 'required|numeric|min:0.01',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
        'items.*.tax_percent' => 'nullable|numeric|min:0|max:100',
    ])]
    public array $items = [];

    public float $subtotal = 0;

    public float $discountTotal = 0;

    public float $taxTotal = 0;

    public float $grandTotal = 0;

    /** @var array<int, array<string, float>> */
    public array $lineTotals = [];

    public function mount(): void
    {
        $this->issue_date = now()->format('Y-m-d');
        $this->items = [
            $this->emptyItem(),
            $this->emptyItem(),
            $this->emptyItem(),
        ];
        $this->recalculate();
    }

    #[On('customer-created')]
    public function onCustomerCreated(int $customerId): void
    {
        $this->customer_id = $customerId;
    }

    public function updatedItems(): void
    {
        $this->recalculate();
    }

    public function addRow(): void
    {
        $this->items[] = $this->emptyItem();
        $this->recalculate();
    }

    public function removeRow(int $index): void
    {
        if (count($this->items) <= 2) {
            return;
        }

        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->recalculate();
    }

    public function save(InvoiceService $invoiceService): void
    {
        $this->validate();
        $this->recalculate();

        $invoice = $invoiceService->store([
            'customer_id' => $this->customer_id,
            'issue_date' => $this->issue_date,
            'notes' => $this->notes,
            'items' => $this->items,
        ]);

        session()->flash('success', 'تم حفظ الفاتورة بنجاح.');

        $this->redirectRoute('invoices.show', $invoice, navigate: true);
    }

    public function render()
    {
        return view('livewire.invoice-form', [
            'customers' => Customer::query()->orderBy('name')->get(),
        ])->layout('layouts.invoice');
    }

    private function emptyItem(): array
    {
        return [
            'description' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'discount_percent' => 0,
            'tax_percent' => 15,
        ];
    }

    private function recalculate(): void
    {
        $calculation = app(InvoiceCalculator::class)->calculate($this->items);

        $this->lineTotals = $calculation['lines'];
        $this->subtotal = $calculation['subtotal'];
        $this->discountTotal = $calculation['discount_total'];
        $this->taxTotal = $calculation['tax_total'];
        $this->grandTotal = $calculation['grand_total'];
    }
}
