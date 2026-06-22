<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'شركة النور للتجارة',
                'email' => 'info@alnoor.example',
                'phone' => '+966501234567',
                'address' => 'الرياض، المملكة العربية السعودية',
            ],
            [
                'name' => 'مؤسسة الأمل',
                'email' => 'contact@alamal.example',
                'phone' => '+966509876543',
                'address' => 'جدة، المملكة العربية السعودية',
            ],
            [
                'name' => 'Global Tech Solutions',
                'email' => 'sales@globaltech.example',
                'phone' => '+97144112233',
                'address' => 'Dubai, UAE',
            ],
            [
                'name' => 'مكتب الريادة',
                'email' => 'office@reyada.example',
                'phone' => '+966112233445',
                'address' => 'الدمام، المملكة العربية السعودية',
            ],
            [
                'name' => 'Bright Future LLC',
                'email' => 'hello@brightfuture.example',
                'phone' => '+97455667788',
                'address' => 'Doha, Qatar',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::query()->create($customer);
        }
    }
}
