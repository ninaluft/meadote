<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PetController extends Controller
{

    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $pets = Auth::user()->pets()->where('status', 'available')->get();
        return view('pets.index', compact('pets'));
    }

    public function myPets()
    {
        $user = Auth::user();
        $availablePets = $user->pets()->where('status', 'available')->get();
        $adoptedPets = $user->pets()->where('status', 'adopted')->get();

        // Contar quantas vezes cada pet foi favoritado
        $favoritesCount = [];
        foreach ($user->pets as $pet) {
            $favoritesCount[$pet->id] = $pet->favoritedBy()->count();
        }

        // Filtrar e ordenar pets favoritados por contagem de favoritos em ordem decrescente
        $favoritedPets = $user->pets->filter(function ($pet) use ($favoritesCount) {
            return ($favoritesCount[$pet->id] ?? 0) > 0;
        })->sortByDesc(function ($pet) use ($favoritesCount) {
            return $favoritesCount[$pet->id];
        });

        return view('pets.my-pets', compact('user', 'availablePets', 'adoptedPets', 'favoritesCount', 'favoritedPets'));
    }


    public function allPets(Request $request)
    {
        $query = Pet::query()->where('status', 'available');

        if ($request->filled('species')) {
            $query->where('species', $request->species);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        if ($request->filled('age')) {
            $query->where('age', $request->age);
        }

        if ($request->filled('is_neutered')) {
            $query->where('is_neutered', $request->is_neutered);
        }

        // Filtro por cidade, usando a relação com o User
        if ($request->filled('city')) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('city', 'like', '%' . $request->city . '%');
            });
        }

        $pets = $query->paginate(9);

        return view('pets.all-pets', compact('pets'));
    }

    public function create()
    {
        return view('pets.create');
    }





    public function show(Pet $pet)
    {
        // Tradução dos valores e criação de um campo auxiliar
        $pet->translated_species = __('pets.species_list.' . $pet->species);
        $pet->gender = __('pets.gender_list.' . $pet->gender);
        $pet->age = __('pets.age_list.' . $pet->age);
        $pet->size = __('pets.size_list.' . $pet->size);
        $pet->status = __('pets.status_list.' . $pet->status);

        // Obter os pets anterior e próximo
        $previousPet = Pet::where('id', '<', $pet->id)
            ->where('status', 'available')
            ->orderBy('id', 'desc')
            ->first();

        $nextPet = Pet::where('id', '>', $pet->id)
            ->where('status', 'available')
            ->orderBy('id', 'asc')
            ->first();

        return view('pets.show', compact('pet', 'previousPet', 'nextPet'));
    }


    public function edit(Pet $pet)
    {
        if (Auth::id() !== $pet->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('pets.edit', compact('pet'));
    }


    public function store(Request $request)
    {
        // Validação dos campos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo_path' => 'nullable|image|max:5120',
            'species' => 'required|in:dog,cat,other',
            'gender' => 'required|in:male,female',
            'age' => 'required|in:puppy,adult,senior',
            'size' => 'required|in:small,medium,large',
            'is_neutered' => 'required|boolean',
            'special_conditions' => 'required|boolean',
            'special_conditions_description' => 'required_if:special_conditions,1|nullable|string|max:1000',
            'description' => 'nullable|string|max:1000',
            'specify_other' => 'required_if:species,other|nullable|string|max:255',
        ]);

        // Variáveis para armazenar o caminho da imagem e o public_id
        $photoPath = null;
        $publicId = null;

        // Se o usuário fez upload de uma imagem
        if ($request->hasFile('photo_path')) {
            // Chama o serviço de upload de imagem e verifica se o upload foi bem-sucedido
            $imageData = $this->imageService->uploadImage($request->file('photo_path')->getRealPath(), 'pets');

            // Verifica se o upload foi bem-sucedido e se o public_id existe
            if (isset($imageData['secure_url']) && isset($imageData['public_id'])) {
                $photoPath = $imageData['secure_url'];  // URL segura da imagem
                $publicId = $imageData['public_id'];    // public_id da imagem
            } else {
                // Caso o upload falhe ou a imagem seja imprópria
                return redirect()->back()->with('error', 'A imagem não pôde ser carregada ou foi considerada imprópria.');
            }
        }

        // Criação do Pet no banco de dados, incluindo o public_id
        $pet = Pet::create([
            'name' => $validated['name'],
            'user_id' => Auth::id(),  // Obtém o ID do usuário autenticado
            'photo_path' => $photoPath,
            'photo_public_id' => $publicId,  // Salva o public_id no banco
            'species' => $validated['species'],
            'gender' => $validated['gender'],
            'age' => $validated['age'],
            'size' => $validated['size'],
            'is_neutered' => $validated['is_neutered'],
            'special_conditions' => $validated['special_conditions'],
            'special_conditions_description' => $validated['special_conditions_description'],
            'description' => $validated['description'],
            'specify_other' => $validated['specify_other'],
        ]);

        // Redireciona o usuário com uma mensagem de sucesso
        return redirect()->route('pets.my-pets')->with('success', 'Pet cadastrado com sucesso.');
    }







    public function update(Request $request, Pet $pet)
    {
        // Verifica se o usuário autenticado é o dono do pet
        if (Auth::id() !== $pet->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validação dos campos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo_path' => 'nullable|image|max:5120',
            'species' => 'required|in:dog,cat,other',
            'gender' => 'required|in:male,female',
            'age' => 'required|in:puppy,adult,senior',
            'size' => 'required|in:small,medium,large',
            'is_neutered' => 'required|boolean',
            'special_conditions' => 'required|boolean',
            'special_conditions_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:1000',
            'specify_other' => 'nullable|string|max:255',
        ]);

        // Verifica se há uma nova imagem
        if ($request->hasFile('photo_path')) {
            // Chama o serviço de upload de imagem e verifica se o upload foi bem-sucedido
            $imageData = $this->imageService->uploadImage($request->file('photo_path')->getRealPath(), 'pets');

            // Verifica se o upload foi bem-sucedido e se o public_id existe
            if (isset($imageData['secure_url']) && isset($imageData['public_id'])) {
                $pet->photo_path = $imageData['secure_url'];    // Atualiza a URL da nova imagem
                $pet->photo_public_id = $imageData['public_id']; // Atualiza o public_id da nova imagem
            } else {
                // Caso o upload falhe ou a imagem seja imprópria
                return redirect()->back()->with('error', 'A imagem foi considerada imprópria.');
            }
        }

        // Atualiza os outros campos
        $pet->update([
            'name' => $validated['name'],
            'species' => $validated['species'],
            'gender' => $validated['gender'],
            'age' => $validated['age'],
            'size' => $validated['size'],
            'is_neutered' => $validated['is_neutered'],
            'special_conditions' => $validated['special_conditions'],
            'special_conditions_description' => $validated['special_conditions_description'],
            'description' => $validated['description'],
            'specify_other' => $validated['specify_other'],
        ]);

        // Redireciona o usuário com uma mensagem de sucesso
        return redirect()->route('pets.show', $pet)->with('success', 'Pet atualizado com sucesso.');
    }







    public function destroy(Pet $pet)
    {
        if ($pet->photo_public_id) {
            // Chama o serviço de exclusão de imagem
            $this->imageService->deleteImage($pet->photo_public_id);
        }

        $pet->delete();

        return redirect()->route('pets.my-pets')->with('success', 'Pet excluído com sucesso.');
    }



    public function favorite($id)
    {
        $pet = Pet::findOrFail($id);
        $user = auth()->user();

        if ($user->hasFavorited($pet)) {
            $user->favorites()->detach($pet->id);  // Desfavoritar
            return response()->json(['favorited' => false]);
        } else {
            $user->favorites()->attach($pet->id);  // Favoritar
            return response()->json(['favorited' => true]);
        }
    }


    public function favorites()
    {
        $favorites = Auth::user()->favorites()->get();
        return view('pets.favorites', compact('favorites'));
    }

    public function adoptedPets()
    {
        // Busca todos os pets cadastrados pelo usuário logado que foram adotados
        $pets = Pet::where('user_id', Auth::id())
            ->where('status', 'adopted')
            ->get();

        // Retorna a view com a lista de pets adotados
        return view('pets.adopted', compact('pets'));
    }
}
