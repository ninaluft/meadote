<?php

namespace App\Http\Controllers;

use App\Models\OngEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OngEventController extends Controller
{
    public function create()
    {
        return view('ong-events.create');
    }

    public function criar()
    {
        return view('ong-events.criar');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after_or_equal:today',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:14',
            'location' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validate image
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('event_photos', 'public');
        }

        OngEvent::create([
            'ong_id' => Auth::user()->ong->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'event_date' => $validated['event_date'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'cep' => $validated['cep'],
            'location' => $validated['location'],
            'photo_path' => $photoPath,
        ]);

        return redirect()->route('ong-events.index')->with('success', 'Event created successfully.');
    }

    public function index(Request $request)
    {
        $query = OngEvent::query();

        // Aplicar filtros se parâmetros de busca forem fornecidos
        if ($request->filled('search_name')) {
            $query->where('title', 'like', '%' . $request->input('search_name') . '%');
        }

        if ($request->filled('search_city')) {
            $query->where('city', 'like', '%' . $request->input('search_city') . '%');
        }

        // Clonar a consulta para reutilizar nos dois tipos de eventos
        $futureEventsQuery = clone $query;
        $pastEventsQuery = clone $query;

        // Futuros eventos
        $futureEvents = $futureEventsQuery->where('event_date', '>=', now())
                                          ->orderBy('event_date', 'asc')
                                          ->paginate(9, ['*'], 'futurePage');

        // Eventos passados
        $pastEvents = $pastEventsQuery->where('event_date', '<', now())
                                      ->orderBy('event_date', 'desc')
                                      ->paginate(9, ['*'], 'pastPage');

        return view('ong-events.index', compact('futureEvents', 'pastEvents'));
    }



    public function show($id)
    {
        $event = OngEvent::findOrFail($id);
        return view('ong-events.show', compact('event'));
    }


    // Edit event

    public function edit(OngEvent $event)
    {
        // Check if the authenticated ONG is the owner of the event
        if (Auth::user()->ong->id !== $event->ong_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('ong-events.edit', compact('event'));
    }

    // Update event
    public function update(Request $request, $id)
    {
        $event = OngEvent::findOrFail($id);

        // Ensure the logged-in user is the one who created the event
        if (Auth::user()->ong->id !== $event->ong_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validation and update logic
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after_or_equal:today',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:14',
            'location' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validate image
        ]);

        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($event->photo_path) {
                Storage::disk('public')->delete($event->photo_path);
            }
            $event->photo_path = $request->file('photo')->store('event_photos', 'public');
        }

        // Update the event
        $event->update($validated);

        return redirect()->route('ong-events.show', $event->id)->with('success', 'Event updated successfully.');
    }

    // Delete event
    public function destroy(OngEvent $event)
    {
        // Check if the authenticated ONG is the owner of the event
        if (Auth::user()->ong->id !== $event->ong_id) {
            abort(403, 'Unauthorized action.');
        }

        $event->delete();

        return redirect()->route('ong-events.index')->with('success', 'Event deleted successfully.');
    }
}
