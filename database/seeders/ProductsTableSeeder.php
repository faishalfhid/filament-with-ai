<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            ['name' => 'Pencil', 'price' => 1000, 'stock' => 100],
            ['name' => 'Notebook', 'price' => 5000, 'stock' => 50],
            ['name' => 'Eraser', 'price' => 500, 'stock' => 200],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}
