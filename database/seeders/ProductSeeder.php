<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop Pro 15',
                'sku' => 'LP15-' . Str::random(5),
                'price' => 125000.00,
                'description' => 'High-performance laptop for professionals.',
            ],
            [
                'name' => 'Wireless Mouse X',
                'sku' => 'WMX-' . Str::random(5),
                'price' => 2500.00,
                'description' => 'Ergonomic wireless mouse with long battery life.',
            ],
            [
                'name' => 'Smartphone Z10',
                'sku' => 'SZ10-' . Str::random(5),
                'price' => 78000.00,
                'description' => 'Flagship smartphone with AMOLED display.',
            ],
            [
                'name' => 'Bluetooth Speaker Mini',
                'sku' => 'BSM-' . Str::random(5),
                'price' => 3200.00,
                'description' => 'Compact speaker with powerful sound.',
            ],
            [
                'name' => 'USB-C Charger 65W',
                'sku' => 'UC65-' . Str::random(5),
                'price' => 1800.00,
                'description' => 'Fast charging USB-C adapter for laptops and phones.',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['sku' => $product['sku']], [
                'name' => $product['name'],
                'sku' => $product['sku'],
                'price' => $product['price'],
                'description' => $product['description']
            ]);
        }
    }
}
