<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Restoran',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'), // Password: password
            'role' => 'admin',
        ]);

        User::factory(5)->create();

        $this->call([
            Menuseeder::class,
            OrderSeeder::class,
        ]);
    }
}
