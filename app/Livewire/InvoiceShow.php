<?php

namespace App\Livewire;

use App\Models\Invoice;
use Livewire\Component;

class InvoiceShow extends Component
{
    public Invoice $invoice;

    public function mount(Invoice $invoice): void
    {
        $this->invoice = $invoice->load(['customer', 'items']);
    }

    public function render()
    {
        return view('livewire.invoice-show')
            ->layout('layouts.invoice', ['title' => 'فاتورة '.$this->invoice->invoice_number]);
    }
}
