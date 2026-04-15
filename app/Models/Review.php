<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Kjo lejon Laravel-in të ruajë të dhënat në këto kolona
    protected $fillable = ['book_id', 'user_id', 'nota', 'komenti'];

    // Lidhja: Vlerësimi i takon një libri
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }

    // Lidhja: Vlerësimi i takon një përdoruesi
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}