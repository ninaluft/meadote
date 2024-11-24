<?php

namespace App\Http\Controllers;

use App\Models\OngEvent;
use App\Services\ImageService;  // Use o ImageService
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OngEventController extends Controller
{
    protected $imageService;

    // Injeta o ImageService no construtor
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }


    public function create()
    {
        return view('ong-events.create');
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
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $photoPath = null;
        $publicId = null;

        // Upload da imagem para o Cloudinary via ImageService
        // Upload da imagem para o Cloudinary via ImageService
        if ($request->hasFile('photo')) {
            $imageData = $this->imageService->uploadImage($request->file('photo')->getRealPath(), 'events');

            // Verifica se a imagem foi considerada imprópria
            if (isset($imageData['secure_url']) && isset($imageData['public_id'])) {
                $photoPath = $imageData['secure_url'];
                $publicId = $imageData['public_id'];
            } else {
                return redirect()->back()->with('error', 'A imagem foi detectada como imprópria.');
            }
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
            'photo_public_id' => $publicId,  // Salva o public_id no banco de dados
        ]);

        return redirect()->route('ong-events.index')->with('success', 'Evento criado com sucesso.');
    }

    public function index(Request $request)
    {
        $query = OngEvent::query()->with('ong');

        if ($request->filled('search_name')) {
            $query->where('title', 'like', '%' . $request->input('search_name') . '%');
        }

        if ($request->filled('search_city')) {
            $query->where('city', 'like', '%' . $request->input('search_city') . '%');
        }

        if ($request->filled('search_organizer')) {
            $query->whereHas('ong', function ($q) use ($request) {
                $q->where('ong_name', 'like', '%' . $request->input('search_organizer') . '%');
            });
        }

        $futureEventsQuery = clone $query;
        $pastEventsQuery = clone $query;

        $futureEvents = $futureEventsQuery->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->paginate(9, ['*'], 'futurePage');

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

    public function myEvents()
    {
        $ongId = Auth::user()->ong->id;

        $futureEvents = OngEvent::where('ong_id', $ongId)
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->get();

        $pastEvents = OngEvent::where('ong_id', $ongId)
            ->where('event_date', '<', now())
            ->orderBy('event_date', 'desc')
            ->get();

        return view('ong-events.my-events', compact('futureEvents', 'pastEvents'));
    }

    public function edit(OngEvent $event)
    {
        if (Auth::user()->ong->id !== $event->ong_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('ong-events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        // Carrega o evento com base no ID fornecido
        $event = OngEvent::findOrFail($id);

        // Verifica se o usuário atual é o dono do evento (ONG associada)
        if (Auth::user()->ong->id !== $event->ong_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validação dos campos do formulário
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after_or_equal:today',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:14',
            'location' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // Validação da imagem
        ]);

        // Se o arquivo de foto foi enviado, processar o upload
        if ($request->hasFile('photo')) {
            // Se houver uma foto antiga, excluí-la
            if ($event->photo_public_id) {
                $this->imageService->deleteImage($event->photo_public_id); // Usa o ImageService para deletar
            }

            // Fazer o upload da nova imagem
            $imageData = $this->imageService->uploadImage($request->file('photo')->getRealPath(), 'events');

            // Verifica se a imagem foi considerada imprópria
            if (isset($imageData['secure_url']) && isset($imageData['public_id'])) {
                // Atualiza os dados da imagem no evento
                $event->photo_path = $imageData['secure_url'];  // Atualiza a URL da imagem
                $event->photo_public_id = $imageData['public_id'];  // Atualiza o public_id da imagem
            } else {
                return redirect()->back()->with('error', 'A imagem foi detectada como imprópria.');
            }
        }

        // Atualiza os outros dados validados do evento
        $event->update($validated);

        // Redireciona para a página de visualização do evento
        return redirect()->route('ong-events.show', $event->id)->with('success', 'Evento atualizado com sucesso.');
    }



    public function destroy(OngEvent $event)
    {
        if (Auth::user()->ong->id !== $event->ong_id) {
            abort(403, 'Unauthorized action.');
        }

        // Deletar a imagem associada usando o public_id
        if ($event->photo_public_id) {
            $this->imageService->deleteImage($event->photo_public_id);
        }

        $event->delete();

        return redirect()->route('ong-events.index')->with('success', 'Evento deletado com sucesso.');
    }
}
