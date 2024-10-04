<?php

namespace App\Http\Controllers;


class UserController extends Controller
{

    public function markNotificationAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }
}
