<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $fillable = [
        'email',
        'username',
        'password',
        'user_type'
    ];
    protected $hidden= [
        'password'
    ];
    public function restaurant()
    {
        return $this->hasOne(Restaurant::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }
}

