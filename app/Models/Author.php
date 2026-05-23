<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    // 1. I tregojmë Laravel-it që emri i kolonës kryesore nuk është 'id', por 'author_id'
    protected $primaryKey = 'author_id'; 

    protected $fillable = ['emri', 'biografia'];

    // 2. Lidhja: Një autor ka shumë libra (hasMany)
    public function books()
    {
        return $this->hasMany(Book::class, 'author_id', 'author_id');
    }
}