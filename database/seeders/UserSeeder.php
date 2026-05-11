<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Sistem',
            'email' => 'admin@mail.com',
            'password' => bcrypt('112233'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Budi Pelanggan',
            'email' => 'budi@mail.com',
            'password' => bcrypt('112233'),
            'role' => 'customer',
        ]);
    }
}
