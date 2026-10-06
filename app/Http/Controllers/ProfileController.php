<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profiles;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{

    public function view_profile()
    {
        $user = auth()->user()->load('profile');

        return view('profile.page', compact('user'));
    }



    public function input_data(Request $request, int $id)
    {

        $request->validate([

            'name' => 'nullable|string|max:255',

            'gender' => 'nullable|in:M,F',

            'description' => 'nullable|string',

            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);



        // find or create profile using user_id

        $profile = Profiles::firstOrCreate(
            ['user_id' => $id],
            [
                'name' => auth()->user()->name ?? 'User',
                'email' => auth()->user()->email ?? '',
                'id_number' => auth()->user()->number_id ?? random_int(100000, 999999),
            ]
        );



        $data = [

            'name' => $request->name,

            'gender' => $request->gender,

            'description' => $request->description,

        ];



        // upload image

        if ($request->hasFile('image')) {


            // delete old image

            if ($profile->image &&
                Storage::disk('public')->exists($profile->image)) {

                Storage::disk('public')
                    ->delete($profile->image);

            }



            // save new image

            $imagePath = $request->file('image')
                ->store('profiles', 'public');



            // save path to database

            $data['image'] = $imagePath;

        }



        // update profile
        $profile->update($data);

        if (!empty($request->name)) {
            auth()->user()->update(['name' => $request->name]);
        }

        // Invalidate cache layer for this user profile & friend list
        \Illuminate\Support\Facades\Cache::forget("user_profile_{$id}");
        \Illuminate\Support\Facades\Cache::forget("user_profile_raw_{$id}");
        \Illuminate\Support\Facades\Cache::forget("user_friends_{$id}");

        return redirect()
            ->back()
            ->with('success','Profile updated');

    }

}