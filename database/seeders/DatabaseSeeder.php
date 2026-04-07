<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin Curator',
                'password' => bcrypt('password'),
                'role' => 'Admin',
            ]
        );

        Employee::firstOrCreate(
            ['name' => 'John Supervisor'],
            ['department' => 'Security', 'is_supervisor' => true]
        );

        Employee::firstOrCreate(
            ['name' => 'Jane Staff'],
            ['department' => 'Operations', 'is_supervisor' => false]
        );

        /*
        $this->call([
            DummyDataSeeder::class,
        ]);
        */
    }
}
