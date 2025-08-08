<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makanan = Category::where('slug', 'makanan-berat')->first();
        $minumanDingin = Category::where('slug', 'minuman-dingin')->first();
        $snack = Category::where('slug', 'snack-makanan-ringan')->first();

        Product::create([
            'category_id' => $makanan->id,
            'sku' => 'MK-001',
            'name' => 'Nasi Goreng Spesial',
            'price' => 25000,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $makanan->id,
            'sku' => 'MK-002',
            'name' => 'Mie Ayam Bakso',
            'price' => 22000,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $minumanDingin->id,
            'sku' => 'MD-001',
            'name' => 'Es Teh Manis',
            'price' => 5000,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $minumanDingin->id,
            'sku' => 'MD-002',
            'name' => 'Es Jeruk',
            'price' => 7000,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $snack->id,
            'sku' => 'SN-001',
            'name' => 'Kentang Goreng',
            'price' => 15000,
            'is_active' => true,
        ]);
    }
}
