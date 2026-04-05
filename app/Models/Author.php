<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    // Kjo i tregon Laravelit që Primary Key nuk është 'id', por 'author_id'
    protected $primaryKey = 'author_id';

    // Sigurohu që emri i tabelës është 'authors' (zakonisht është automatike, por po e shtojmë për siguri)
    protected $table = 'authors';
}