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
                <form action="{{ route('temporary-housing.index') }}" method="GET" class="mb-6 flex space-x-2">
                    <div class="flex-1">
                        <x-input id="search" name="search" type="text" :value="request('search')" class="w-full"
                            placeholder="{{ __('Buscar por nome ou cidade') }}" />
                    </div>
                    <x-button>{{ __('Buscar') }}</x-button>
                </form>

                <!-- Lista de tutores -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($tutors as $tutor)
                        <a href="{{ route('user.public-profile', $tutor->user_id) }}"
                            class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex items-center space-x-6 hover:shadow-md transition-shadow duration-300"
                            role="article" aria-labelledby="tutor-{{ $tutor->id }}">

                            <!-- Foto do Usuário -->
                            <div class="flex-shrink-0">
                                @if (!empty($tutor->user->profile_photo_path))
                                    <img src="{{ asset('storage/' . $tutor->user->profile_photo_path) }}" alt="{{ $tutor->full_name }}"
                                        class="h-24 w-24 rounded-full object-cover border-2 border-gray-300">
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
