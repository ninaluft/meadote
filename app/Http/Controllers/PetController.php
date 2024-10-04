<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    public function index()
    {
        $pets = Auth::user()->pets()->where('status', 'available')->get();
        return view('pets.index', compact('pets'));
    }

    public function myPets()
    {
        $pets = Auth::user()->pets()->get();
        return view('pets.my-pets', compact('pets'));
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo_path' => 'nullable|image|max:2048',
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


        // Verifica se a espécie é "Outro" e se deve salvar a especificação
        $petData = $request->all();
        if ($request->species !== 'other') {
            $petData['specify_other'] = null; // Se não for "Outro", não salva a especificação
        }

        $pet = new Pet($petData);
        $pet->user_id = Auth::id();

        if ($request->hasFile('photo_path')) {
            $pet->photo_path = $request->file('photo_path')->store('pets', 'public');
        }

        $pet->save();

        return redirect()->route('pets.my-pets')->with('success', 'Pet cadastrado com sucesso.');
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

    public function update(Request $request, Pet $pet)
    {
        if (Auth::id() !== $pet->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'photo_path' => 'nullable|image|max:2048',
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

        $petData = $request->all();
        if ($request->species !== 'other') {
            $petData['specify_other'] = null;
        }

        $pet->fill($petData);

        if ($request->hasFile('photo_path')) {
            $pet->photo_path = $request->file('photo_path')->store('pets', 'public');
        }


        $pet->save();

        return redirect()->route('pets.show', $pet)->with('success', 'Pet atualizado com sucesso.');
    }

    public function destroy(Pet $pet)
    {
        if (Auth::id() !== $pet->user_id) {
            abort(403, 'Unauthorized action.');
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
