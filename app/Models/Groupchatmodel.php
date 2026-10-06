<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupchatmodel extends Model
{
    protected $table = 'group_chat'; // change if your table name is different

    protected $fillable = [
        'group_name',
        'user_id',
        'message',
        'group_id',
        'media_path',
        'media_type',
    ];

  public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
      public function group_id()
    {
        return $this->belongsTo(
            Groupid::class,
            'group_id'
        );
    }
}