<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col max-w-4xl mx-auto px-4">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight break-words break-all">
                {{ $event->title }}
            </h2>

            @if (Auth::check() && Auth::user()->user_type === 'ong' && Auth::user()->ong->id === $event->ong_id)
                <div class="flex space-x-2 mt-4 self-end">
                    <!-- Botão de Editar -->
                    <a href="{{ route('events.edit', $event->id) }}"
                        class="bg-yellow-300 hover:bg-yellow-400 text-black font-semibold py-1 px-3 rounded-lg text-lg focus:outline-none focus:bg-yellow-400 focus:ring focus:ring-yellow-200"
                        aria-label="Editar o evento {{ $event->title }}">
                        {{ __('Editar') }}
                    </a>

                    <!-- Botão de Excluir -->
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                        onsubmit="return confirm('{{ __('Tem certeza de que deseja excluir este evento?') }}');" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded-lg text-lg focus:outline-none focus:bg-red-700 focus:ring focus:ring-red-300"
                            aria-label="Excluir o evento {{ $event->title }}">
                            {{ __('Excluir') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 space-y-6">
                <!-- Foto do Evento -->
                @if ($event->photo_path)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $event->photo_path) }}" alt="{{ $event->title }}"
                            class="rounded-lg w-full h-auto shadow-sm cursor-pointer"
                            onclick="openModal('{{ asset('storage/' . $event->photo_path) }}')">
                    </div>
                @endif

                <!-- Detalhes do Evento -->
                <div class="space-y-4">
                    <div class="text-gray-600 space-y-2 text-base">
                        <p><strong>{{ __('Data do Evento: ') }}</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</p>

                        @if ($event->event_time)
                            <p><strong>{{ __('Horário do Evento: ') }}</strong> {{ $event->event_time }}</p>
                        @endif

                        <p><strong>{{ __('Local: ') }}</strong> {{ $event->location }}</p>

                        <p><strong>{{ __('Cidade: ') }}</strong> {{ $event->city }}, {{ $event->state }}</p>

                        <p><strong>{{ __('CEP: ') }}</strong> {{ $event->cep }}</p>

                        <p class="mt-2"><strong>{{ __('Descrição: ') }}</strong></p>
                        <p class="mt-2 whitespace-pre-wrap">{{ $event->description }}</p>
                    </div>

                    <div class="mt-4 text-base">
                        <p><strong>{{ __('Organizador do Evento: ') }}</strong>
                            <a href="{{ route('user.public-profile', $event->ong->user->id) }}"
                                class="text-indigo-600 hover:underline"
                                aria-label="Visualizar perfil público de {{ $event->ong->ong_name }}">
                                {{ $event->ong->ong_name }}
                            </a>
                        </p>
                    </div>

                    <div class="mt-4 flex space-x-3 items-center">
                        <!-- Botão de Compartilhar -->
                        <button type="button"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg flex items-center text-lg focus:outline-none focus:bg-blue-600 focus:ring focus:ring-blue-300"
                            id="shareButton">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                            </svg>
                            {{ __('Compartilhar') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Imagem -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center" onclick="closeModal()">
        <div class="relative">
            <button onclick="closeModal()" class="absolute top-0 right-0 m-4 text-white text-3xl">&times;</button>
            <img id="modalImage" src="" alt="Imagem em tamanho real" class="max-w-full max-h-screen rounded-lg object-contain" onclick="event.stopPropagation()">
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

    <!-- Script para compartilhar o evento -->
    <script>
        document.getElementById('shareButton').addEventListener('click', function() {
            const shareData = {
                title: 'Evento: {{ $event->title }}',
                text: 'Participe do evento "{{ $event->title }}" organizado por {{ $event->ong->ong_name }}.',
                url: '{{ route('ong-events.show', $event->id) }}'
            };

            if (navigator.share) {
                navigator.share(shareData)
                    .then(() => console.log('Event shared successfully'))
                    .catch((error) => console.log('Error sharing:', error));
            } else {
                // Fallback if Web Share API is not supported
                navigator.clipboard.writeText(shareData.url)
                    .then(() => alert('Link copiado para a área de transferência!'))
                    .catch(err => console.error('Erro ao copiar link: ', err));
            }
        });
    </script>
</x-app-layout>
