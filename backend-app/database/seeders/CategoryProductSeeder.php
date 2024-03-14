<?php

namespace Database\Seeders;

use App\Models\CategoryProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categoriesProducts = [
            [
                "name_category" => "Elektronik"
            ], 
            [
                "name_category" => "Buku"
            ], 
            [
                "name_category" => "Dapur"
            ], 
            [
                "name_category" => "Fashion"
            ], 
            [
                "name_category" => "Kecantikan"
            ], 
            [
                "name_category" => "Mainan & Hobi"
            ], 
            [
                "name_category" => "Olahraga"
            ], 
            [
                "name_category" => "Otomotif"
            ], 
            [
                "name_category" => "Rumah Tangga"
            ], 
            [
                "name_category" => "Produk Lainnya"
            ], 
            
        ];

        foreach($categoriesProducts as $categoriesProduct)
        {
            CategoryProduct::create($categoriesProduct);
        }
    }
}
