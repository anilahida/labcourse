<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'kategori_id';

    // Këto janë fushat që Laravel i lejon të shkruhen në DB
    protected $fillable = [
        'emri', 
        'pershkrimi', 
        'kategoria_prind_id'
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'kategoria_prind_id');
    }
}