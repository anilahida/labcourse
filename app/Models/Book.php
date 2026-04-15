<?php

namespace App\Models;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $primaryKey = 'book_id'; // Kontrollo nëse në migration e ke 'id' apo 'book_id'

    protected $fillable = [
        'titulli',
        'isbn',
        'cmimi',
        'sasia',
        'author_id',
        'category_id',
        'pershkrimi'
    ];

    // Lidhja: Libri i takon një Autori
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    // Lidhja: Libri i takon një Kategorie
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'kategori_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'book_id', 'book_id');
    }
}