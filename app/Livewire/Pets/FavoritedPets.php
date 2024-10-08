<?php

namespace App\Livewire\Pets;



use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FavoritedPets extends Component
{
    public function render()
    {
        $user = Auth::user();

       // Obter todos os pets do usuário que foram favoritados por outros usuários, com pelo menos um favorito
       $favoritedPets = $user->pets()
       ->withCount('favoritedBy')
       ->having('favorited_by_count', '>', 0)
       ->orderBy('favorited_by_count', 'desc')
       ->get();

        // Contar quantas vezes cada pet foi favoritado
        $favoritesCount = $favoritedPets->mapWithKeys(function ($pet) {
            return [$pet->id => $pet->favorited_by_count];
        });

        return view('livewire.pets.favorited-pets', compact('favoritedPets', 'favoritesCount'));
    }
}
