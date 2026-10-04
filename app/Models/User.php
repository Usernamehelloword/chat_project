<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;


 
 class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'number_id',
    ];

    public function profile()
    {
        return $this->hasOne(Profiles::class, 'user_id', 'id');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function addfriends()
    {
        return $this->hasMany(Addfriend::class, 'user_id');
    }
     public function friends()
    {
        return $this->hasMany(Addfriend::class, 'user_id');
    }


    public function friendOf()
    {
        return $this->hasMany(Addfriend::class, 'friend_id');
    
        }
        public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
 
   
}


