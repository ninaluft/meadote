<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ONGs cadastradas em nosso sistema') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Link de Filtros -->
                <div class="flex justify-end mb-4">
                    <div class="cursor-pointer flex items-center text-indigo-600 hover:text-indigo-800 font-semibold"
                        id="toggleFiltersLink">
                        <span id="toggleFiltersText">Filtros</span>
                        <svg id="toggleFiltersIcon" class="ml-2 w-5 h-5 transition-transform transform rotate-0"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Formulário de busca - Ocultado inicialmente -->
                <form action="{{ route('ongs.index') }}" method="GET" id="filtersForm" class="mb-6 hidden">
                    <div class="flex flex-wrap gap-2">
                        <!-- Nome da ONG -->
                        <div class="flex flex-col">
                            <x-label for="ong_name" value="Nome da ONG" />
                            <x-input id="ong_name" name="ong_name" value="{{ request('ong_name') }}"
                                placeholder="Nome da ONG"
                                class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-max w-full px-4 py-2" />
                        </div>

                        <!-- Cidade -->
                        <div class="flex flex-col">
                            <x-label for="city" value="Cidade" />
                            <x-input id="city" name="city" value="{{ request('city') }}" placeholder="Cidade"
                                class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-max w-full px-4 py-2" />
                        </div>

                        <!-- Botão de buscar -->
                        <div class="flex items-end">
                            <x-button>
                                <i class="fas fa-search text-white m-1"></i>
                            </x-button>
                        </div>
                    </div>
                </form>

                @if ($ongs->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($ongs as $ong)
                            <div class="bg-white shadow-md rounded-lg overflow-hidden flex p-4">
                                <a href="{{ route('user.public-profile', $ong->user->id) }}" class="flex-shrink-0">
                                    <div
                                        class="h-32 w-32 bg-gray-200 flex items-center justify-center rounded-full overflow-hidden">
                                        @if (!empty($ong->user->profile_photo))
                                            <!-- Usando o componente x-image para exibir a foto -->
                                            <x-image :src="$ong->user->profile_photo" alt="{{ $ong->ong_name }}"
                                                class="h-32 w-32 object-cover rounded-full" />
                                        @else
                                            <!-- Usando o componente x-initials-avatar para exibir as iniciais -->
                                            <x-initials-avatar :user="$ong->user" class="h-32 w-32 text-4xl" />
                                        @endif
                                    </div>
                                </a>

                                <div class="ml-6 flex flex-col justify-center">
                                    <h2 class="text-lg font-bold mb-2">
                                        <a href="{{ route('user.public-profile', $ong->user->id) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $ong->ong_name }}
                                        </a>
                                    </h2>
                                    <p class="text-gray-600">
                                        {{ $ong->user->city }}, {{ $ong->user->state }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Links de Paginação -->
                    <div class="mt-6">
                        {{ $ongs->links() }}
                    </div>
                @else
                    <p class="text-center text-gray-600">{{ __('Nenhuma ONG encontrada.') }}</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Script para alternar a visibilidade da barra de filtros
        const toggleFiltersLink = document.getElementById('toggleFiltersLink');
        const filtersForm = document.getElementById('filtersForm');
        const toggleFiltersText = document.getElementById('toggleFiltersText');
        const toggleFiltersIcon = document.getElementById('toggleFiltersIcon');

        toggleFiltersLink.addEventListener('click', () => {
            filtersForm.classList.toggle('hidden');

            if (filtersForm.classList.contains('hidden')) {
                toggleFiltersText.textContent = 'Mostrar Filtros';
                toggleFiltersIcon.classList.remove('rotate-180');
            } else {
                toggleFiltersText.textContent = 'Esconder Filtros';
                toggleFiltersIcon.classList.add('rotate-180');
            }
        });
    </script>
</x-app-layout>
