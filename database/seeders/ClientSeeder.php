<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Ema Gashi',
            'email' => 'ema@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123')
        ]);

        \App\Models\User::create([
            'name' => 'Agon Berisha',
            'email' => 'agon@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123')
        ]);
    }
}
