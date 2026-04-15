<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['user_id', 'book_id', 'shuma', 'metoda_pageses', 'statusi'];
    use HasFactory;
}
