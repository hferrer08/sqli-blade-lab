<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products_demo')->insert([
        [
            'name' => 'Manzana Fuji',
            'sku' => 'PRD-0001',
            'price' => 1200.50,
            'stock' => 50,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Pera Williams',
            'sku' => 'PRD-0002',
            'price' => 980.00,
            'stock' => 35,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Uva Red Globe',
            'sku' => 'PRD-0003',
            'price' => 1500.00,
            'stock' => 20,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
    }
}
