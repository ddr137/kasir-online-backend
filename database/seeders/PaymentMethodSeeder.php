<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::create([
            'name' => 'Tunai',
            'icon' => 'cash-icon.png',
            'account_name' => 'Kasir',
            'account_number' => 'N/A',
            'is_active' => true,
        ]);

        PaymentMethod::create([
            'name' => 'Debit BCA',
            'icon' => 'bca-icon.png',
            'account_name' => 'Toko Sejahtera',
            'account_number' => '0987654321',
            'is_active' => true,
        ]);
    }
}
