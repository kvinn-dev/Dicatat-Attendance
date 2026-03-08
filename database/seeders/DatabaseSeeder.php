<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // password yang diketahui
            'role' => 'admin',
        ]);

        Employee::create([
            'user_id' => $admin->id,
            'employee_id' => 'EMP-001',
            'department' => 'Management',
            'position' => 'Administrator',
            'status' => 'active',
        ]);

        // User default: Kevin
        $kevin = User::create([
            'name' => 'Kevin',
            'email' => 'kevin@example.com',
            'password' => Hash::make('kevin123'), // password yang diketahui
            'role' => 'employee',
        ]);

        Employee::create([
            'user_id' => $kevin->id,
            'employee_id' => 'EMP-002',
            'department' => 'Engineering',
            'position' => 'Backend Developer',
            'status' => 'active',
        ]);

        User::factory(50)->create();
    }
}
