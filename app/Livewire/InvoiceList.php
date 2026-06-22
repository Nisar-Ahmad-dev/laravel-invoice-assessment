<?php

namespace App\Livewire;

use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.invoice-list', [
            'invoices' => Invoice::query()
                ->with('customer')
                ->latest()
                ->paginate(15),
        ])->layout('layouts.invoice', ['title' => 'الفواتير المحفوظة']);
    }
}
