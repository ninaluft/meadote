<?php

namespace App\Http\Controllers;

use App\Models\Ong;
use App\Models\User;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    /**
     * Display the public profile of the user.
     */
    public function show($id)
    {
        // Fetch the user whose profile will be displayed
        $user = User::findOrFail($id);

        // Initialize the $profileData variable
        $profileData = null;

        // Check the profile type (ONG or Tutor)
        if ($user->user_type === 'ong') {
            $profileData = Ong::where('user_id', $user->id)->firstOrFail();
        } elseif ($user->user_type === 'tutor') {
            $profileData = $user->tutor;
        }

        // Retrieve available pets registered by the user
        $pets = $user->pets()->where('status', 'available')->get();

        // Fetch social networks related to the user
        $socialNetworks = $user->socialNetworks;

        return view('user.public-profile', compact('user', 'profileData', 'pets', 'socialNetworks'));
    }
}
