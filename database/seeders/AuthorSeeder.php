<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        \App\Models\Author::create([
            'emri' => 'Ismail', 
            'mbiemri' => 'Kadare',
            'biografia' => 'Shkrimtar i njohur shqiptar.'
        ]);

        \App\Models\Author::create([
            'emri' => 'Gjergj', 
            'mbiemri' => 'Fishta',
            'biografia' => 'Poeti kombëtar i shqiptarëve.'
        ]);
    }
}