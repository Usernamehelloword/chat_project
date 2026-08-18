<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Profiles;
use App\Models\Addfriend;
use App\Models\Groupconnect;
use App\Models\Groupid;

class Authcontroller extends Controller
{
   


public function view(Request $request)
{
    // =========================
    // LOGGED-IN USER
    // =========================

    $user = User::findOrFail(Auth::id());

    // =========================
    // PROFILE
    // =========================

    $profile = Profiles::where(
        'user_id',
        Auth::id()
    )->first();

    // =========================
    // SEARCH
    // =========================

    $search_name = $request->input('search_name');

    $users = collect();

    if (!empty($search_name)) {

        $users = User::where(
                'name',
                'like',
                '%' . $search_name . '%'
            )
            ->orWhere(
                'email',
                'like',
                '%' . $search_name . '%'
            )
            ->orWhere(
                'number_id',
                'like',
                '%' . $search_name . '%'
            )
            ->limit(10)
            ->get();
    }

    // =========================
    // FRIENDS
    // =========================

    $friend = Addfriend::where(function ($query) {

        $query->where('user_id', Auth::id())
              ->orWhere('friend_id', Auth::id());

    })
    ->where(function ($query) {

        // Only private friends
        $query->whereNull('group_name')
              ->orWhere('group_name', '')
              ->orWhere('group_name', '0');

    })
    ->with([
        'user.profile',
        'friend.profile'
    ])
    ->get()
    ->unique(function ($item) {

        return collect([
            $item->user_id,
            $item->friend_id
        ])
        ->sort()
        ->implode('-');

    });

    // =========================
    // GROUPS
    // =========================



$groupIds = Groupconnect::where(
    'user_id',
    Auth::id()
)->pluck('group_id');

$groups = Groupid::whereIn(
    'id',
    $groupIds
)
->orderBy('created_at', 'desc')
->get();

    // =========================
    // RETURN VIEW
    // =========================

    return view('main', compact(
        'user',
        'profile',
        'users',
        'search_name',
        'friend',
        'groups'
    ));
}

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            // Prevent session fixation
            $request->session()->regenerate();

            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.page');
            }

            return redirect()->route('main');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('email.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $id_number = random_int(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'number_id' => $id_number,
        ]);

        Profiles::create([
            'name' => $request->name,
            'user_id' => $user->id,
            'email' => $request->email,
            'id_number' => $id_number,
        ]);

        return redirect()
            ->route('logins')
            ->with('success', 'Registration successful. Please log in.');
    }
}
