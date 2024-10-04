<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PetProfile extends Component
{
    public $petId;

    public function mount($id)
    {
        $this->petId = $id; // O id do pet é passado e armazenado
    }

    public function render()
    {
        return view('livewire.pet-profile'); // Certifique-se de que essa view exista
    }
}
