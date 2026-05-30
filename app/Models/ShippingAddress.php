<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','emri','mbiemri','rruga',
        'qyteti','shteti','kodi_postar','telefoni','default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
