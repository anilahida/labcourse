<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model // Emri këtu duhet të jetë Client
{
    use HasFactory;

    // Kjo lejon Laravel-in të mbushë këto fusha në databazë
    protected $fillable = [
        'name',
        'email',
    ];
}
