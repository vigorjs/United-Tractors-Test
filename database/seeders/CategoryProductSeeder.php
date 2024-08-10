<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_products')->insert([
            [
                'name' => 'Electronics',
                'description' => 'Devices and gadgets such as smartphones, laptops, and tablets.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Clothing',
                'description' => 'Apparel including shirts, pants, and accessories.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Home Appliances',
                'description' => 'Appliances like refrigerators, washing machines, and microwaves.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
