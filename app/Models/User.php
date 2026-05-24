<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject; // Për sigurinë JWT

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    // Emri i tabelës në databazë (zakonisht është 'users')
    protected $table = 'users';

    // Kolonat që lejohen të mbushen
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // =======================================================
    // FUNKSIONET E DETAGJUARA PËR JWT (Siguria e API-ve)
    // =======================================================
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->is_admin ? 'admin' : 'buyer' // Shton rolin brenda token-it
        ];
    }
}