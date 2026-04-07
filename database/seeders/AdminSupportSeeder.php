<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin_support'],
            [
                'name' => 'System Overseer',
                'password' => Hash::make('support123'),
                'role' => 'Admin',
            ]
        );
    }
}
