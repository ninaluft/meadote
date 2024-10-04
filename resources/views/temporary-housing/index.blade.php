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
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200" role="article"
                            aria-labelledby="tutor-{{ $tutor->id }}">
                            <h2 class="text-xl font-semibold text-gray-900 mb-2" id="tutor-{{ $tutor->id }}">
                                {{ $tutor->full_name }}</h2>
                            <p class="text-gray-700 mb-1">{{ __('Cidade') }}: {{ $tutor->user->city }}</p>
                            <p class="text-gray-700 mb-1">{{ __('Estado') }}: {{ $tutor->user->state }}</p>
                            </p>

                            <a href="{{ route('user.public-profile', $tutor->user_id) }}"
                                class="mt-4 inline-block text-indigo-600 hover:text-indigo-900 font-semibold"
                                aria-label="{{ __('Ver perfil de ') . $tutor->full_name }}">
                                {{ __('Ver perfil') }}
                            </a>
                        </div>
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
