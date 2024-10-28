<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tutores que oferecem Lar Temporário') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Formulário de busca -->
                <form action="{{ route('temporary-housing.index') }}" method="GET" class="mb-6">
                    <div class="relative flex-1">
                        <input id="search" name="search" type="text" value="{{ request('search') }}"
                            placeholder="{{ __('Buscar por nome ou cidade') }}"
                            class="w-full pl-4 pr-10 border-gray-300 rounded-lg p-2 focus:border-indigo-500 focus:ring-indigo-500" />
                        <button type="submit" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Display Active Filters Summary with Clear Filters Button -->
                @php
                    $activeFilters = [];
                    if (request('search')) {
                        $activeFilters[] = 'Busca: ' . request('search');
                    }
                @endphp

                @if (count($activeFilters) > 0)
                    <div class="mb-6 p-2 bg-teal-50 text-teal-800 rounded-md border border-teal-200 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="mb-2 md:mb-0">
                            <p class="font-semibold">Filtros ativos:</p>
                            <ul class="list-disc list-inside">
                                @foreach ($activeFilters as $filter)
                                    <li>{{ $filter }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Clear Filters Button -->
                        <a href="{{ route('temporary-housing.index') }}"
                            class="mt-2 md:mt-0 px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600 transition shadow-sm">
                            Limpar Filtros
                        </a>
                    </div>
                @endif

                <!-- Lista de tutores -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($tutors as $tutor)
                        <a href="{{ route('user.public-profile', $tutor->user_id) }}"
                            class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex items-center space-x-6 hover:shadow-md transition-shadow duration-300"
                            role="article" aria-labelledby="tutor-{{ $tutor->id }}">

                            <!-- Foto do Usuário -->
                            <div class="flex-shrink-0">
                                @if (!empty($tutor->user->profile_photo))
                                    <x-image :src="$tutor->user->profile_photo" alt="Foto de perfil de {{ $tutor->full_name }}"
                                        class="rounded-full w-24 h-24 md:w-24 md:h-24 object-cover" />
                                @else
                                    <div class="h-24 w-24 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-3xl font-bold text-white">
                                            {{ strtoupper(substr($tutor->full_name, 0, 1)) }}{{ strtoupper(substr($tutor->full_name, 1, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Detalhes do Tutor -->
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 mb-1" id="tutor-{{ $tutor->id }}">
                                    {{ $tutor->full_name }}
                                </h2>
                                <p class="text-gray-700">{{ __('Cidade') }}: {{ $tutor->user->city }}</p>
                                <p class="text-gray-700">{{ __('Estado') }}: {{ $tutor->user->state }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-500">{{ __('Nenhum tutor encontrado que oferece lar temporário.') }}</p>
                    @endforelse
                </div>

                <!-- Paginação -->
                <div class="mt-8">
                    {{ $tutors->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
