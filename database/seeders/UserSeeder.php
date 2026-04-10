<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Wikrama
        $admin = User::create([
            'name' => 'admin wikrama',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admi1'), // 4 chars admin + pos 1
            'role' => 'admin',
            'is_default_password' => true,
        ]);


        User::create([
            'name' => 'erdi',
            'email' => 'erdieka@gmail.com',
            'password' => Hash::make('erdi'),
            'role' => 'admin',
            'is_default_password' => true,
        ]);

        // Staff/Operator for testing
        User::create([
            'name' => 'putri',
            'email' => 'putri@gmail.com',
            'password' => Hash::make('putr1'),
            'role' => 'staff',
            'is_default_password' => true,
        ]);
    }
}
