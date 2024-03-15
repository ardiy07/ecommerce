<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $products = [
            [
                'name_product' => 'baju wanita',
                'price' => 30000,
                'stock' => 10,
                'image' => '/storage/images/products/JKefFGFVZ6gEmW3zsoBO2lqApkcrCEzJtXguLJ6z.jpg',
                'description' => 'eerupakan baju wanita yang sangat elegant',
                'store_id' => 1,
                'category_product_id' => 4
            ],
            [
                'name_product' => 'baju pria',
                'price' => 30000,
                'stock' => 10,
                'image' => '/storage/images/products/JKefFGFVZ6gEmW3zsoBO2lqApkcrCEzJtXguLJ6z.jpg',
                'description' => 'merupakan baju wanita yang sangat elegant',
                'store_id' => 1,
                'category_product_id' => 4
            ],
            [
                'name_product' => 'baju muslim pria',
                'price' => 30000,
                'stock' => 10,
                'image' => '/storage/images/products/JKefFGFVZ6gEmW3zsoBO2lqApkcrCEzJtXguLJ6z.jpg',
                'description' => 'merupakan baju wanita yang sangat elegant',
                'store_id' => 2,
                'category_product_id' => 4
            ],
        ];

        foreach($products as $product){
            Product::create($product);
        }
    }
}
