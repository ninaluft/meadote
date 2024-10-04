<?php

namespace App\Http\Controllers;

use App\Models\OngEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OngDashboardController extends Controller
{
    public function index()
    {
        return view('ong.dashboard');
    }

    public function showDashboard()
    {
        // Retrieve events for the logged-in ONG
        $events = OngEvent::where('ong_id', Auth::user()->ong->id)->get();

        // Pass the events to the view
        return view('ong.dashboard', compact('events'));
    }
}
