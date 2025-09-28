<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Shamim Haque',
                'email' => 'shamim@example.com',
                'username' => 'shamim',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Ayesha Rahman',
                'email' => 'ayesha@example.com',
                'username' => 'ayesha',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Tanvir Ahmed',
                'email' => 'tanvir@example.com',
                'username' => 'tanvir',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Nusrat Jahan',
                'email' => 'nusrat@example.com',
                'username' => 'nusrat',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Rafiul Islam',
                'email' => 'rafiul@example.com',
                'username' => 'rafiul',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['username'=>$user['username']], $user);
        }
    }
}
