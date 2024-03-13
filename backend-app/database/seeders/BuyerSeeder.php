<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BuyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $buyer = [
            [
                'name' => 'buyer',
                'username' => 'buyer1',
                'email' => 'buyer@gmail.com',
                'password' => Hash::make('buyer123')
            ]
        ];

        foreach ($buyer as $user) {
            $u = User::create($user);
            $u->assignRole('buyer');
        }
    }
}
