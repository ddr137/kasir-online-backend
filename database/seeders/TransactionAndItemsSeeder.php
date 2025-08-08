<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionAndItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data master yang diperlukan
        $user = User::first();
        $paymentMethod = PaymentMethod::where('name', 'Tunai')->first();
        $products = Product::all();

        $totalPrice1 = 0;

        // --- Buat Transaksi Pertama (Lunas) ---
        // Tambah item 1 ke transaksi 1
        $product1 = $products->find(1); // Nasi Goreng
        $quantity1 = 2;
        $subtotal1 = $product1->price * $quantity1;
        $totalPrice1 += $subtotal1;

        // Tambah item 2 ke transaksi 1
        $product2 = $products->find(3); // Es Teh
        $quantity2 = 2;
        $subtotal2 = $product2->price * $quantity2;
        $totalPrice1 += $subtotal2;

        // In your seeder logic
        $paidAmount = max($totalPrice1, 50000); // Ensure paid amount is at least total price
        $changeAmount = $paidAmount - $totalPrice1;

        $transaction1 = Transaction::create([
            'user_id' => $user->id,
            'payment_method_id' => $paymentMethod->id,
            'trx_number' => 'TRX-' . time() . '-' . Str::upper(Str::random(4)),
            'status' => 'completed',
            'total_price' => $totalPrice1,
            'paid_amount' => $paidAmount,
            'change_amount' => $changeAmount,
        ]);

        $transaction1->items()->createMany([
            [
                'product_id' => $product1->id,
                'quantity' => $quantity1,
                'price' => $product1->price,
                'subtotal' => $subtotal1,
            ],
            [
                'product_id' => $product2->id,
                'quantity' => $quantity2,
                'price' => $product2->price,
                'subtotal' => $subtotal2,
            ]
        ]);
    }
}
