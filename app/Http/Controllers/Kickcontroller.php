<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Addfriend;
use App\Models\Groupconnect;
use App\Models\Groupid;
 use App\Models\Groupchatmodel;
 use Illuminate\Support\Facades\DB;
 use App\Models\Textprivaye;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Metadata\Group;

class Kickcontroller extends Controller
{
    public function remove_friend(int $id)
    {
        Addfriend::where('user_id', Auth::id())
            ->where('friend_id', $id)
            ->delete();
        Textprivaye::where('user_id', Auth::id())
            ->where('friend_id', $id)
            ->delete();
 
        return redirect()->back();
    }
    public function remove_from_group(int $id){
        Groupid::where('user_id', $id)->delete();
        Groupconnect::where('user_id', $id)->delete();
          return redirect()->back();

    }
     
public function remove_group(int $id, string $name)
{
    $group = Groupid::where('id', $id)->first();

    if (!$group) {
        return redirect()
            ->back()
            ->with('error', 'Group not found.');
    }

    // ONLY OWNER
    if ($group->user_id != Auth::id()) {
        abort(403, 'You are not the owner of this group.');
    }

    Groupconnect::where('group_id', $id)->delete();

    Groupchatmodel::where('group_name', $name)
        ->where('user_id', Auth::id())
        ->delete();

    $group->delete();

    return redirect()
        ->route('main')
        ->with('message', 'Group deleted successfully.');
}


// public function remove_group(int $id)
// {
//     DB::transaction(function () use ($id) {


//     Groupid::where('group_id', $id)->delete();

//     Groupconnect::where('group_id', $id)->delete();

//     Groupchatmodel::where('group_id', $id)->delete();

//     return redirect()->back();


//     });

//     return redirect()
//         ->back()
//         ->with('success', 'Group deleted successfully.');
// }
}