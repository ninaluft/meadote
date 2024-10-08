<?php

namespace App\Livewire\Pets;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class AdoptedPets extends Component
{
    use WithPagination;

    public $searchNameTemp = '';
    public $searchGenderTemp = '';
    public $searchSpeciesTemp = '';

    public $searchName = '';
    public $searchGender = '';
    public $searchSpecies = '';

    protected $paginationTheme = 'tailwind';

    public function updating($field)
    {
        $this->resetPage(); // Reseta a página ao atualizar um filtro
    }

    public function applyFilters()
    {
        $this->searchName = $this->searchNameTemp;
        $this->searchGender = $this->searchGenderTemp;
        $this->searchSpecies = $this->searchSpeciesTemp;

        $this->resetPage(); // Reseta a página ao aplicar os filtros
    }

    public function render()
    {
        // Obter o usuário autenticado
        $user = Auth::user();

        // Consulta para obter os pets adotados do usuário autenticado
        $query = $user->pets()->where('status', 'adopted');

        // Aplicar filtros conforme os valores fornecidos pelo usuário
        if (!empty($this->searchName)) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        }

        if (!empty($this->searchGender)) {
            $query->where('gender', $this->searchGender);
        }

        if (!empty($this->searchSpecies)) {
            $query->where('species', $this->searchSpecies);
        }

        // Paginar os resultados
        $adoptedPets = $query->paginate(6);

        return view('livewire.pets.adopted-pets', compact('adoptedPets'));
    }
}
