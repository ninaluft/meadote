<div class="card" onclick="openPetModal({{ $pet->id }})" style="cursor: pointer;" role="button" tabindex="0" aria-label="Visualizar perfil de {{ $pet->name }}">
    <img src="{{ $pet->photo_path ? asset('storage/' . $pet->photo_path) : asset('images/default-pet.jpg') }}"
         class="card-img-top object-cover h-48 w-full"
         alt="Foto do pet {{ $pet->name }}">

    <div class="card-body break-words break-all overflow-hidden">
        <div class="flex justify-between items-center">
            <h5 class="card-title text-xl font-bold">{{ $pet->name }}</h5>
            <x-favorite-button :petId="$pet->id" :isFavorited="Auth::check() ? Auth::user()->hasFavorited($pet) : false"
                aria-label="{{ Auth::check() && Auth::user()->hasFavorited($pet) ? 'Remover dos favoritos' : 'Adicionar aos favoritos' }}" />
        </div>
        <p class="card-text text-sm text-gray-600">{{ __('pets.species') }}: {{ __('pets.species_list.' . $pet->species) }}</p>
        <p class="card-text text-sm text-gray-600">{{ __('pets.gender') }}: {{ __('pets.gender_list.' . $pet->gender) }}</p>
        <p class="card-text text-sm text-gray-600">{{ __('pets.size') }}: {{ __('pets.size_list.' . $pet->size) }}</p>
        <p class="card-text text-sm text-gray-600">{{ __('pets.location') }}: {{ $pet->user->city }}, {{ $pet->user->state }}</p>
    </div>
</div>

<script>
    // Permitir navegação com Enter para ativar o onclick
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                redirectToPetProfile({{ $pet->id }});
            }
        });
    });
</script>
