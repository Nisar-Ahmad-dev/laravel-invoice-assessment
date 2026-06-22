<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddCustomer extends Component
{
    public bool $showForm = false;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|email|max:255')]
    public ?string $email = null;

    #[Validate('nullable|string|max:50')]
    public ?string $phone = null;

    #[Validate('nullable|string|max:500')]
    public ?string $address = null;

    public function toggleForm(): void
    {
        $this->showForm = ! $this->showForm;

        if (! $this->showForm) {
            $this->reset(['name', 'email', 'phone', 'address']);
            $this->resetValidation();
        }
    }

    public function save(): void
    {
        $validated = $this->validate();

        $customer = Customer::query()->create($validated);

        $this->dispatch('customer-created', customerId: $customer->id);

        $this->reset(['name', 'email', 'phone', 'address']);
        $this->resetValidation();
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.add-customer');
    }
}
