<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Models\Profiles;
use App\Models\Addfriend;
use App\Models\Groupconnect;
use App\Models\Groupid;

class AuthController extends Controller
{
    public function view(Request $request)
    {
        $userId = Auth::id();

        // CACHE LAYER: User & Profile cached for 1 hour (3600s)
        $user = Cache::remember("user_profile_{$userId}", 3600, function () use ($userId) {
            return User::with('profile')->findOrFail($userId);
        });

        $profile = $user->profile ?? Cache::remember("user_profile_raw_{$userId}", 3600, function () use ($userId) {
            return Profiles::where('user_id', $userId)->first();
        });

        // SEARCH (dynamic, hidden fields protected)
        $search_name = $request->input('search_name');
        $users = collect();

        if (!empty($search_name)) {
            $users = User::select(['id', 'name', 'email', 'number_id'])
                ->where('name', 'like', '%' . $search_name . '%')
                ->orWhere('email', 'like', '%' . $search_name . '%')
                ->orWhere('number_id', 'like', '%' . $search_name . '%')
                ->limit(10)
                ->get();
        }

        // CACHE LAYER: Friends list cached for 5 minutes (300s)
        $friend = Cache::remember("user_friends_{$userId}", 300, function () use ($userId) {
            return Addfriend::where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhere('friend_id', $userId);
            })
            ->where(function ($query) {
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
        });

        // CACHE LAYER: User groups cached for 5 minutes (300s)
        $groups = Cache::remember("user_groups_{$userId}", 300, function () use ($userId) {
            $groupIds = Groupconnect::where('user_id', $userId)->pluck('group_id');
            return Groupid::whereIn('id', $groupIds)
                ->orderBy('created_at', 'desc')
                ->get();
        });

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

        return redirect()->route('logins');
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
