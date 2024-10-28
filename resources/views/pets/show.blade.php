<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center max-w-4xl mx-auto px-4">
            <!-- Título -->
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight break-words break-all text-center sm:text-left mb-4 sm:mb-0">
                {{ __('pets.pet_profile') }} {{ $pet->name }}
            </h2>

            <!-- Botões Editar e Excluir -->
            @if (Auth::check() && Auth::id() === $pet->user_id)
                <div class="flex space-x-2">
                    <x-button-edit href="{{ route('pets.edit', $pet->id) }}" ariaLabel="Editar pet">
                        {{ __('Editar') }}
                    </x-button-edit>

                    <!-- Botão de Excluir com ícone -->
                    <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" class="inline-block"
                        onsubmit="return confirm('{{ __('pets.confirm_delete') }}');">
                        @csrf
                        @method('DELETE')
                        <x-button-delete :action="route('pets.destroy', $pet->id)"
                            confirmMessage="{{ __('Tem certeza de que deseja excluir este pet?') }}"
                            ariaLabel="Excluir pet">
                            Excluir
                        </x-button-delete>
                    </form>
                </div>
            @endif

        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-4">
                <div class="md:flex md:p-4">

                    <!-- Foto do Pet -->
                    <div class="md:w-1/3 mb-4 md:mb-0">
                        <img src="{{ Str::startsWith($pet->photo_path, 'http') ? $pet->photo_path : asset($pet->photo_path) }}"
                        alt="{{ __('pets.description') }} {{ $pet->name }}"
                        class="rounded-lg w-full h-auto shadow-sm cursor-pointer"
                        onclick="openModal('{{ Str::startsWith($pet->photo_path, 'http') ? $pet->photo_path : asset($pet->photo_path) }}')">


                    </div>

                    <!-- Detalhes do Pet -->
                    <div class="md:w-2/3 md:ml-4">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-3xl font-semibold text-gray-800 break-words break-all">{{ $pet->name }}
                            </h2>

                            <!-- Botão de Favorito -->
                            <x-favorite-button :petId="$pet->id" :isFavorited="Auth::check() ? Auth::user()->hasFavorited($pet) : false"
                                aria-label="{{ Auth::check() && Auth::user()->hasFavorited($pet) ? 'Remover dos favoritos' : 'Adicionar aos favoritos' }}" />
                        </div>

                        <div class="text-gray-600 space-y-2 text-base">
                            <p><strong>{{ __('pets.species') }}:</strong>
                                @if (strtolower($pet->species) === 'other' && !empty($pet->specify_other))
                                    {{ ucfirst($pet->specify_other) }}
                                @else
                                    {{ ucfirst($pet->translated_species) }}
                                @endif
                            </p>

                            <p><strong>{{ __('pets.gender') }}:</strong> {{ ucfirst($pet->gender) }}</p>
                            <p><strong>{{ __('pets.age') }}:</strong> {{ ucfirst($pet->age) }}</p>
                            <p><strong>{{ __('pets.size') }}:</strong> {{ ucfirst($pet->size) }}</p>
                            <p><strong>{{ __('pets.neutered') }}:</strong> {{ $pet->is_neutered ? 'Sim' : 'Não' }}</p>
                            <p><strong>{{ __('pets.special_conditions') }}:</strong>
                                {{ $pet->special_conditions ? 'Sim' : 'Não' }}</p>

                            @if ($pet->special_conditions)
                                <p><strong>{{ __('pets.special_conditions_description') }}:</strong>
                                    {{ $pet->special_conditions_description }}</p>
                            @endif

                            <p class="mt-2"><strong>{{ __('pets.description') }}: </strong> </p>
                            <p class="mt-2 whitespace-pre-wrap">{!! nl2br(e($pet->description)) !!}</p>
                        </div>

                        <div class="mt-4 text-base">
                            <p><strong>{{ __('pets.registered_by') }}:</strong>
                                <a href="{{ route('user.public-profile', $pet->user->id) }}"
                                    class="text-indigo-600 hover:underline"
                                    aria-label="Visualizar perfil público de {{ $pet->user->user_type === 'ong' ? $pet->user->ong->ong_name : ($pet->user->user_type === 'tutor' ? $pet->user->tutor->full_name : $pet->user->name) }}">
                                    {{ $pet->user->user_type === 'ong' ? $pet->user->ong->ong_name : ($pet->user->user_type === 'tutor' ? $pet->user->tutor->full_name : $pet->user->name) }}
                                </a>
                            </p>


                            <p><strong>{{ __('pets.location') }}:</strong> {{ $pet->user->city }},
                                {{ $pet->user->state }}</p>
                            <p><strong>{{ __('pets.status') }}:</strong> <span
                                    class="{{ $pet->status === 'Disponível' ? 'text-green-500' : 'text-red-500' }}">{{ ucfirst($pet->status) }}</span>
                            </p>
                        </div>

                        <div class="mt-4 flex space-x-3 items-center">
                            @if ($pet->status !== 'Adotado')
                                <!-- Botão de Adotar -->
                                @auth
                                    @php
                                        $existingForm = \App\Models\AdoptionForm::where('submitter_user_id', Auth::id())
                                            ->where('pet_id', $pet->id)
                                            ->first();
                                    @endphp

                                    @if ($existingForm)
                                        <p class="text-yellow-500 font-semibold">{{ __('pets.form_sent_success') }}</p>
                                    @else
                                        <form action="{{ route('adoption-form.create', $pet->id) }}" method="GET">
                                            @csrf
                                            <x-button icon="fas fa-house" color="green" size="sm"
                                                ariaLabel="{{ __('pets.adopt_button') }} {{ $pet->name }}">
                                                {{ __('pets.adopt_button') }}
                                            </x-button>
                                        </form>
                                    @endif
                                @else
                                    <!-- Mostrar botão de adotar para usuários não autenticados -->
                                    <a href="{{ route('login', ['redirectTo' => route('adoption-form.create', $pet->id)]) }}"
                                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg text-lg"
                                        aria-label="{{ __('pets.adopt_button') }} {{ $pet->name }}">
                                        {{ __('pets.adopt_button') }}
                                    </a>
                                @endauth
                            @endif

                            <x-button-share id="sharePetButton" title="Pet: {{ $pet->name }}"
                                text="Adote o {{ $pet->name }}! Veja mais informações no perfil do pet."
                                url="{{ route('pets.show', $pet->id) }}" ariaLabel="Compartilhar perfil do pet">
                                {{ __('Compartilhar Pet') }}
                            </x-button-share>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Imagem -->
            <div id="imageModal"
                class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center"
                onclick="closeModal()">
                <div class="relative">
                    <button onclick="closeModal()"
                        class="absolute top-0 right-0 m-4 text-white text-3xl">&times;</button>
                    <img id="modalImage" src="" alt="Imagem em tamanho real"
                        class="max-w-full max-h-screen rounded-lg object-contain" onclick="event.stopPropagation()">
                </div>
            </div>

            <!-- Navegação Anterior e Próxima -->
            <div class="flex justify-between mt-6">
                @if ($previousPet)
                    <a href="{{ route('pets.show', $previousPet->id) }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-full shadow-md text-lg">
                        &larr; {{ __('pets.previous_pet') }}
                    </a>
                @endif
                @if ($nextPet)
                    <a href="{{ route('pets.show', $nextPet->id) }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-full shadow-md ml-auto text-lg">
                        {{ __('pets.next_pet') }} &rarr;
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Script para o modal de imagem -->
    <script>
        function openModal(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
    </script>

    <!-- Script to share the pet's profile -->
    <script>
        function sharePet() {
            const shareData = {
                title: '{{ __('pets.pet_profile') }} {{ $pet->name }}',
                text: 'Veja este adorável pet disponível para adoção: {{ $pet->name }}.',
                url: '{{ route('pets.show', $pet->id) }}'
            };

            if (navigator.share) {
                navigator.share(shareData)
                    .then(() => console.log('Pet profile shared successfully'))
                    .catch((error) => console.log('Error sharing:', error));
            } else {
                navigator.clipboard.writeText(shareData.url)
                    .then(() => alert('Link copiado para a área de transferência!'))
                    .catch(err => console.error('Erro ao copiar link: ', err));
            }
        }
    </script>
</x-app-layout>
