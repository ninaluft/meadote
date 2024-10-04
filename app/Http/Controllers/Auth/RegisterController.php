<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        // Create the new user
        $user = app(CreateNewUser::class)->create($request->all());

        // Autenticate the user after registration
        Auth::login($user);

        // Redirect based on the user type
        if ($user->user_type === 'tutor') {
            return redirect()->route('tutor.dashboard');
        } elseif ($user->user_type === 'ong') {
            return redirect()->route('ong.dashboard');
        }

        // Default fallback
        return redirect('/');
    }
}
