<?php

namespace App\Livewire\Pets;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class AvailablePets extends Component
{
    use WithPagination;

    public $searchName = '';
    public $searchGender = '';
    public $searchSpecies = '';

    public $filtersApplied = false;

    protected $paginationTheme = 'tailwind';

    public function updating($field)
    {
        $this->resetPage(); // Reseta a página ao atualizar um filtro
    }

    public function applyFilters()
    {
        $this->filtersApplied = true;
        $this->resetPage(); // Reseta a página ao aplicar os filtros
    }

    public function render()
    {
        $query = Auth::user()->pets()->where('status', 'available');

        // Aplica os filtros apenas se o botão de busca foi clicado
        if ($this->filtersApplied) {
            if ($this->searchName) {
                $query->where('name', 'like', '%' . $this->searchName . '%');
            }

            if ($this->searchGender) {
                $query->where('gender', $this->searchGender);
            }

            if ($this->searchSpecies) {
                $query->where('species', $this->searchSpecies);
            }
        }

        $availablePets = $query->paginate(6);

        return view('livewire.pets.available-pets', compact('availablePets'));
    }
}
