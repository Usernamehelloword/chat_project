<?php

namespace App\Http\Controllers;

use App\Models\Profiles;
use Illuminate\Http\Request;

class Groupprofile extends Controller
{
  public function index(int $id)
{
    $attibute = Profiles::where('user_id', $id)->first();

    return view('group.profile', compact('attibute'));
}
    
}
