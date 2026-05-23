<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
   
public function run(): void
    {
        
        \Schema::disableForeignKeyConstraints();

        
        $this->call([
            AuthorSeeder::class,
            ClientSeeder::class,
            
        ]);

     
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