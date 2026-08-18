<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Groupconnect;

/*
|--------------------------------------------------------------------------
| Private chat
|--------------------------------------------------------------------------
*/
Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


/*
|--------------------------------------------------------------------------
| Group chat
|--------------------------------------------------------------------------
*/
use App\Models\Groupid;


Broadcast::channel(
    'group-chat.{groupId}',
    function ($user, $groupId) {

        $group = Groupid::find($groupId);

        if (!$group) {
            return false;
        }

        $isOwner = (int) $group->user_id === (int) $user->id;

        $isMember = Groupconnect::where('group_id', $groupId)
            ->where('user_id', $user->id)
            ->exists();

        return $isOwner || $isMember;
    }
);