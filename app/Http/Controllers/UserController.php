<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function redirectToDashboard()
    {
        switch (Auth::user()->user_type) {
            case 'tutor':
                return redirect()->route('tutor.dashboard');
            case 'ong':
                return redirect()->route('ong.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            default:
                return view('dashboard');
        }
    }


    public function markNotificationAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }
}
