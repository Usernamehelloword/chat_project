<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Groupconnect;
use App\Models\Groupid;
use App\Models\Textprivaye;

/*
|--------------------------------------------------------------------------
| Private chat
|--------------------------------------------------------------------------
*/
Broadcast::channel('chat.{id}', function ($user, $id) {
    if ((int) $user->id === (int) $id) {
        return true;
    }

    $isMember = Textprivaye::where('chat_id', $id)
        ->where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('friend_id', $user->id);
        })
        ->exists();

    if ($isMember) {
        return true;
    }

    return !empty($user);
});


/*
|--------------------------------------------------------------------------
| Group chat
|--------------------------------------------------------------------------
*/
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