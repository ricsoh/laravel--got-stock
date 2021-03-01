<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;

class ProfileController extends Controller
{
    //
    public function index(){
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        return view('profile', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    //
    public function create(){
        return view('createProfile');
    }

    // ME => use for creating profile after 1st time registering
    public function postCreate()
    {
        $data = request()->validate([
            'prof_name' => 'required',
            'prof_image' => 'image',
        ]);

        // Load the existing profile
        $user = Auth::user();

        // create a new profile if not there
        $profile = Profile::where('user_id', $user->id)->first();
        if (empty($profile)) {
            $profile = new Profile();
            $profile->user_id = $user->id;
        }

        $profile->name = request('prof_name');
        $profile->address = request('prof_address');
        $profile->postcode = request('prof_postcode');
        $profile->email = request('prof_email');
        $profile->website = request('prof_website');

        // Save the new profile pic... if there is one in the request()!
        if (request()->has('prof_image')) {
            $imagePath = request('prof_image')->store('uploads', 'public');
            $profile->image = $imagePath;
        }else{
            $imagePath = "../images/no_image.jfif"; // Add no image picture
            $profile->image = $imagePath;
        }

        // Now, save it all into the database
        $updated = $profile->save();
        if ($updated) {
            return redirect('/home');
        }        
    }

    // => ME, used for editing existing profile
    public function postEdit()
    {
        $data = request()->validate([
            'prof_name' => 'required',
            'prof_image' => 'image',
        ]);

        // Load the existing profile
        $profileID = request('prof_id');
        $profile = Profile::find($profileID); // This is for updating selected ID
        
        $profile->name = request('prof_name');
        $profile->address = request('prof_address');
        $profile->postcode = request('prof_postcode');
        $profile->email = request('prof_email');
        $profile->website = request('prof_website');

        // Save the new profile pic... if there is one in the request()!
        if (request()->has('prof_image')) {
            $imagePath = request('prof_image')->store('uploads', 'public');
            $profile->image = $imagePath;
        }

        // Now, save it all into the database
        $updated = $profile->save();
        if ($updated) {
            return redirect('/home');
        }        
    }
}


