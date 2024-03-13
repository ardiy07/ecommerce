<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $merchant = [
            [
                'name' => 'merchant',
                'username' => 'merchant1',
                'email' => 'merchant@gmail.com',
                'password' => Hash::make('merchant123')
            ]
        ];

        foreach ($merchant as $user) {
            $u = User::create($user);
            $u->assignRole('merchant');
        }
    }
}
