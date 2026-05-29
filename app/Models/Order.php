<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Shto këtë pjesë nëse nuk e ke:
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    protected $fillable = ['client_id', 'book_title', 'total_amount', 'status'];
}