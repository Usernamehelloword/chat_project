<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Groupchatmodel;
use App\Models\Addfriend;
use App\Models\Groupconnect;
use App\Models\Profiles;
use App\Models\Groupid;
use App\Models\User;

use App\Events\Groupchat;

class Groupchatcontroller extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GROUP PAGE
    |--------------------------------------------------------------------------
    */

    public function view()
    {
        return view('group.page');
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE GROUP
    |--------------------------------------------------------------------------
    */

    public function Create_group(Request $request)
    {
        $data = $request->validate([
            'name_group' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        $userId = auth()->id();

        // Create group
        $group = Groupid::create([
            'group_name' => $data['name_group'],
            'user_id'    => $userId,
        ]);

        // Add owner to group members
        Groupconnect::firstOrCreate([
            'group_id' => $group->id,
            'user_id'  => $userId,
        ]);

        // IMPORTANT:
        // If your main page displays groups using Addfriend,
        // you must also create this record.
        Addfriend::firstOrCreate(
            [
                'user_id'    => $userId,
                'group_name' => $group->group_name,
            ],
            [
                'chat_id'   => 0,
                'friend_id' => 0,
            ]
        );

        return redirect()
            ->route('main')
            ->with('success', 'Group created successfully!');
    }


    /*
    |--------------------------------------------------------------------------
    | OPEN GROUP CHAT
    |--------------------------------------------------------------------------
    */

    public function openGroupChat(Request $request)
    {
        $data = $request->validate([
            'group_id' => [
                'required',
                'integer',
            ],
        ]);

        $groupId = (int) $data['group_id'];

        /*
        |--------------------------------------------------------------------------
        | Find actual group
        |--------------------------------------------------------------------------
        */

        $groupInfo = Groupid::find($groupId);

        if (!$groupInfo) {
            return response()->json([
                'success' => false,
                'message' => 'Group not found.',
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Check membership
        |--------------------------------------------------------------------------
        */

        $isOwner = (int) $groupInfo->user_id === (int) auth()->id();

        $isMember = Groupconnect::where(
            'group_id',
            $groupId
        )
            ->where(
                'user_id',
                auth()->id()
            )
            ->exists();

        if (!$isOwner && !$isMember) {
            return response()->json([
                'success' => false,
                'message' => 'You are not a member of this group.',
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Get messages
        |--------------------------------------------------------------------------
        */

        $messages = Groupchatmodel::where(
            'group_id',
            $groupId
        )
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success'    => true,
            'group_id'   => $groupId,
            'group_name' => $groupInfo->group_name,
            'messages'   => $messages,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SEND GROUP MESSAGE
    |--------------------------------------------------------------------------
    */

    public function sendmessage(Request $request)
    {
        $data = $request->validate([
            'group_id' => [
                'required',
                'integer',
            ],

            'message' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        $groupId = (int) $data['group_id'];

        /*
        |--------------------------------------------------------------------------
        | Check group exists
        |--------------------------------------------------------------------------
        */

        $group = Groupid::find($groupId);

        if (!$group) {
            return response()->json([
                'success' => false,
                'message' => 'Group not found.',
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Check membership
        |--------------------------------------------------------------------------
        */

        $isOwner = (int) $group->user_id === (int) auth()->id();

        $isMember = Groupconnect::where(
            'group_id',
            $groupId
        )
            ->where(
                'user_id',
                auth()->id()
            )
            ->exists();

        if (!$isOwner && !$isMember) {
            return response()->json([
                'success' => false,
                'message' => 'You are not a member of this group.',
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Create message
        |--------------------------------------------------------------------------
        */

        $message = Groupchatmodel::create([
            'group_id'   => $groupId,
            'group_name' => $group->group_name,
            'user_id'    => auth()->id(),
            'message'    => $data['message'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Load sender
        |--------------------------------------------------------------------------
        */

        $message->load('user');

        /*
        |--------------------------------------------------------------------------
        | Broadcast
        |--------------------------------------------------------------------------
        */

        broadcast(
            new Groupchat($message)
        );

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | INSERT MESSAGE
    |--------------------------------------------------------------------------
    |
    | Optional old method.
    | Keep it only if another page is still using it.
    |
    */

    public function insertmessage(Request $request)
    {
        $data = $request->validate([
            'group_id' => [
                'required',
                'integer',
            ],

            'message' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        $group = Groupid::find($data['group_id']);

        if (!$group) {
            return response()->json([
                'success' => false,
                'message' => 'Group not found.',
            ], 404);
        }

        $isOwner = (int) $group->user_id === (int) auth()->id();

        $isMember = Groupconnect::where(
            'group_id',
            $group->id
        )
            ->where(
                'user_id',
                auth()->id()
            )
            ->exists();

        if (!$isOwner && !$isMember) {
            return response()->json([
                'success' => false,
                'message' => 'You are not a member of this group.',
            ], 403);
        }

        $message = Groupchatmodel::create([
            'group_id'   => $group->id,
            'group_name' => $group->group_name,
            'user_id'    => auth()->id(),
            'message'    => $data['message'],
        ]);

        $message->load('user');

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT GROUP
    |--------------------------------------------------------------------------
    */

    public function index_edit_group(
        int $id,
        string $group_name
    ) {
        $list_friends = Addfriend::where(
            'user_id',
            Auth::id()
        )
            ->where(
                'friend_id',
                '!=',
                0
            )
            ->pluck('friend_id');

        $friends = Profiles::whereIn(
            'user_id',
            $list_friends
        )->get();

        $group_id = $id;

        $member_ids = Groupconnect::where(
            'group_id',
            $group_id
        )
            ->pluck('user_id');

        $members = User::whereIn(
            'id',
            $member_ids
        )->get();

        $group = Groupid::where('id', $id)->firstOrFail();

        // Check if logged-in user owns this group
        $isOwner = Auth::id() == $group->user_id;

        return view(
            'group.edit',
            compact(
                'friends',
                'members',
                'group_id',
                'group_name',
                'isOwner'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADD FRIENDS TO GROUP
    |--------------------------------------------------------------------------
    */

    public function list_friend(Request $request)
    {
        $data = $request->validate([
            'group_id' => [
                'required',
                'integer',
            ],

            'group_name' => [
                'required',
                'string',
                'max:100',
            ],

            'user_id' => [
                'required',
                'array',
            ],

            'user_id.*' => [
                'required',
                'integer',
            ],
        ]);

        $group = Groupid::find($data['group_id']);

        if (!$group) {
            return back()->with(
                'error',
                'Group not found.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Only owner can add members
        |--------------------------------------------------------------------------
        */

        if ((int) $group->user_id !== (int) auth()->id()) {
            return back()->with(
                'error',
                'Only the group owner can add members.'
            );
        }

        foreach ($data['user_id'] as $userId) {

            Groupconnect::firstOrCreate([
                'group_id' => $group->id,
                'user_id'  => $userId,
            ]);
        }

        return redirect()
            ->route('main')
            ->with(
                'success',
                'Users added to group successfully.'
            );
    }
}
