<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupid extends Model
{
    protected $table = 'group_id';

    protected $fillable = [
        'group_name',
        'user_id',
    ];


    public function members()
    {
        return $this->hasMany(
            Groupconnect::class,
            'group_id'
        );
    }

    public function messages()
    {
        return $this->hasMany(
            Groupchatmodel::class,
            'group_id'
        );
    }
}