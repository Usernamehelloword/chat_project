<?php

namespace App\Http\Controllers;

use App\Models\Profiles;
use App\Models\User;
use Illuminate\Http\Request;

class Groupprofile extends Controller
{
    public function index($id)
    {
        // 1. Try finding User by primary key ID
        $user = User::with('profile')->find($id);

        // 2. If not found, try finding User by number_id
        if (!$user) {
            $user = User::with('profile')->where('number_id', $id)->first();
        }

        // 3. Resolve profile
        $attibute = null;
        if ($user && $user->profile) {
            $attibute = $user->profile;
        } else {
            $attibute = Profiles::where('user_id', $id)
                ->orWhere('id_number', $id)
                ->orWhere('id', $id)
                ->first();

            if ($attibute && !$user && $attibute->user_id) {
                $user = User::with('profile')->find($attibute->user_id);
            }
        }

        // 4. If user exists but profile row doesn't, create one
        if ($user && !$attibute) {
            $attibute = Profiles::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $user->name,
                    'email' => $user->email,
                    'id_number' => $user->number_id,
                ]
            );
        }

        // 5. Ensure attibute has consistent fields fallback from user
        if ($attibute && $user) {
            if (empty($attibute->name)) {
                $attibute->name = $user->name;
            }
            if (empty($attibute->email)) {
                $attibute->email = $user->email;
            }
            if (empty($attibute->id_number)) {
                $attibute->id_number = $user->number_id;
            }
        }

        // 6. Handle not found gracefully
        if (!$attibute && !$user) {
            return redirect()->route('main')->with('error', 'Profile not found.');
        }

        return view('group.profile', compact('attibute', 'user'));
    }
}
