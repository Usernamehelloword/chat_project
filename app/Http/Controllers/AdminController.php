<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.page', compact('users'));
    }
    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        return view('admin.update', compact('user'));
    }
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email']));

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.page')->with('success', 'User updated successfully.');
    }
    public function delete(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.page')
            ->with('success', 'User deleted successfully.');
    }
}
