<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    // Kjo lejon Laravel-in te mbushe keto kolona permes Seeder-it
    protected $fillable = ['emri', 'biografia'];
}