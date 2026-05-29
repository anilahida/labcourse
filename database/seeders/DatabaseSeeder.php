<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \Schema::disableForeignKeyConstraints();

        // 1. Ekzekutohen seeder-at e autorëve dhe klientëve të shoqes
        $this->call([
            AuthorSeeder::class,
            ClientSeeder::class,
        ]);

        // 2. Shtohet përdoruesi Admin (Anila) automatikisht me is_admin
        \App\Models\User::create([
            'name' => 'anila',
            'email' => 'anila@gmail.com',
            'password' => bcrypt('password123'),
            'is_admin' => 1,
        ]);

        // 3. Shtohen kuponat nga kodi i shoqes
        \DB::table('coupons')->insert([
            [
                'code' => 'SUPER20',
                'type' => 'Percentage',
                'value' => 20.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'FESTA10',
                'type' => 'Fixed',
                'value' => 10.00,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 4. Shtohen dërgesat nga kodi i shoqes
        \DB::table('shipments')->insert([
            [
                'order_id' => 1,
                'tracking_number' => 'TRK-98765-AL',
                'status' => 'Shipped',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'order_id' => 2,
                'tracking_number' => 'TRK-11223-AL',
                'status' => 'Delivered',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        \Schema::enableForeignKeyConstraints();
    }
}