<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $stores = [
            [
                'name_store' => 'toko pertama',
                'user_id' => 2
            ],
            [
                'name_store' => 'toko kedua',
                'user_id' => 3
            ]
            ];
        foreach($stores as $store){
            Store::create($store);
        }
    }
}
