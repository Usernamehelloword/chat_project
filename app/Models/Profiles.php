<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    use HasFactory;
      protected $table = 'profiles';
   protected $fillable = [
    'user_id',
    'id_number',
    'name',
    'email',
    'image',
    'gender',
    'description',
];

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
