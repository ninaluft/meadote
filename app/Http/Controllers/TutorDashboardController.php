<?php

namespace App\Http\Controllers;

use App\Models\AdoptionForm;
use Illuminate\Support\Facades\Auth;

class TutorDashboardController extends Controller
{
    public function index()
    {
        // Get the logged-in tutor
        $tutor = Auth::user();

        // Fetch the pets registered by the tutor
        $registeredPets = $tutor->pets;

        // Count adopted and available pets
        $adoptedPetsCount = $registeredPets->where('status', 'adopted')->count();
        $availablePetsCount = $registeredPets->where('status', 'available')->count();

        // Get all pending adoption requests for the tutor's pets
        $adoptionRequests = AdoptionForm::whereHas('pet', function ($query) use ($tutor) {
            $query->where('user_id', $tutor->id);
        })->where('status', 'pending')->get();

        // Pass the data to the view
        return view('tutor.dashboard', compact('registeredPets', 'adoptedPetsCount', 'availablePetsCount', 'adoptionRequests'));
    }
}
