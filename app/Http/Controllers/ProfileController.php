<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profiles;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{

    public function view_profile()
    {
        $user = auth()->user();

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



        // find profile using user_id

        $profile = Profiles::where('user_id', $id)
                    ->firstOrFail();



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



        return redirect()
            ->back()
            ->with('success','Profile updated');

    }

}