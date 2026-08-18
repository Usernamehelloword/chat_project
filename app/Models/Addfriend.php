<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addfriend extends Model
{
    use HasFactory;
     protected $table = 'add_friends';
    protected $fillable = [
        'chat_id',
        'user_id',
        'friend_id',
        'group_name',
        
    ];
     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }
    
}
