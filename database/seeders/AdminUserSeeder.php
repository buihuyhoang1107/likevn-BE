<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'email' => 'admin@example.com',
                'password' => Hash::make('123456'),
                'full_name' => 'Administrator',
                'type' => 'admin',
                'balance' => 0,
                'monthly_deposit' => 0,
                'level' => 1,
                'is_verified' => true,
                'is_active' => true,
            ]
        );
    }
}
