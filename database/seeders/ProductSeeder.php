<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Smartphone',
                'price' => 69999,
                'image' => 'smartphone.jpg',
                'product_category_id' => 1, // Assuming 'Electronics' has ID 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jeans',
                'price' => 4999,
                'image' => 'jeans.jpg',
                'product_category_id' => 2, // Assuming 'Clothing' has ID 2
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Refrigerator',
                'price' => 150000,
                'image' => 'refrigerator.jpg',
                'product_category_id' => 3, // Assuming 'Home Appliances' has ID 3
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
