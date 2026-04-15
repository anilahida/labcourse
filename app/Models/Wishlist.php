<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    // Kjo vija këtu e rregullon gabimin që po sheh në ekran
    protected $fillable = ['user_id', 'book_id'];

    // Lidhja me modelin Book që të shfaqen emrat e librave
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }
}