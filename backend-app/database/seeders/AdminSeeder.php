<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = [
            [
                'name' => 'admin',
                'username' => 'admin1',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123')
            ]
        ];

        foreach ($admin as $user) {
            $u = User::create($user);
            $u->assignRole('admin');
        }
    }
}
