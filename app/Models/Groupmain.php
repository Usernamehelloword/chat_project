<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupmain extends Model
{
    use HasFactory;
      protected $table = 'group_chat_main';
    protected $fillable = [
    
        'user_id',
        'group_name',
        
    ];
       public function user()
    {
        return $this->belongsTo(User::class);
    }
}
