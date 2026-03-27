<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Admin account
        User::create([
            'username' => 'admin',
            'name'     => 'Admin',
            'email'    => 'admin@solesearch.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        $this->call([
            ShoeSeeder::class,
        ]);
    }
}
