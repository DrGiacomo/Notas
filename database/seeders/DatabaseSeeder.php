<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'test@example.com',
            'password' => bcrypt('123456789'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Profesor User',
            'email' => 'profesor@example.com',
            'password' => bcrypt('1234567890'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Estudiante User',
            'email' => 'estudiante@example.com',
            'password' => bcrypt('0123456789'),
        ]);
        $this->call(RoleSeeder::class);
    }
}
