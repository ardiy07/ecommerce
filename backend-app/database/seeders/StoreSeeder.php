<?php

namespace Database\Seeders;

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
        DB::table('stores')->insert([
            'name_store' => 'toko pertama',
            'user_id' => 2
        ]);
        DB::table('stores')->insert([
            'name_store' => 'toko kedua',
            'user_id' => 3
        ]);
    }
}
