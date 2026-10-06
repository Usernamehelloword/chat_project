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

    // Verify if user is sender or receiver of existing messages in this chat
    $isMember = Textprivaye::where('chat_id', $id)
        ->where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('friend_id', $user->id);
        })
        ->exists();

    if ($isMember) {
        return true;
    }

    // Verify if user is part of friendship record with this chat_id
    $isFriend = \App\Models\Addfriend::where('chat_id', $id)
        ->where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere('friend_id', $user->id);
        })
        ->exists();

    if ($isFriend) {
        return true;
    }

    // Verify deterministic chatId (min * 100000 + max) with friendship check
    $userId = (int) $user->id;
    if ($id > 100000) {
        $candidate1 = (int) floor($id / 100000);
        $candidate2 = (int) ($id % 100000);
        $otherId = ($userId === $candidate1) ? $candidate2 : (($userId === $candidate2) ? $candidate1 : null);

        if ($otherId) {
            return \App\Models\Addfriend::where(function ($q) use ($userId, $otherId) {
                $q->where('user_id', $userId)->where('friend_id', $otherId);
            })->orWhere(function ($q) use ($userId, $otherId) {
                $q->where('user_id', $otherId)->where('friend_id', $userId);
            })->exists();
        }
    }

    return false;
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

/*
|--------------------------------------------------------------------------
| User private channel (friend notifications, alerts, etc.)
|--------------------------------------------------------------------------
*/
Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});