<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('products')->insert([
            'name_product' => 'baju wanita',
            'price' => 30000,
            'stock' => 10,
            'description' => 'eerupakan baju wanita yang sangat elegant',
            'store_id' => 1,
            'category_product_id' => 4
        ]);

        DB::table('products')->insert([
            'name_product' => 'baju pria',
            'price' => 30000,
            'stock' => 10,
            'description' => 'merupakan baju wanita yang sangat elegant',
            'store_id' => 1,
            'category_product_id' => 4
        ]);

        DB::table('products')->insert([
            'name_product' => 'baju muslim pria',
            'price' => 30000,
            'stock' => 10,
            'description' => 'merupakan baju wanita yang sangat elegant',
            'store_id' => 2,
            'category_product_id' => 4
        ]);
    }
}
