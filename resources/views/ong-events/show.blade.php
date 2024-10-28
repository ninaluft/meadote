<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center max-w-4xl mx-auto px-4">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight break-words break-all">
                {{ $event->title }}
            </h2>

            @if (Auth::check() && Auth::user()->user_type === 'ong' && Auth::user()->ong->id === $event->ong_id)
                <div class="flex space-x-2">
                    <!-- Botão de Editar com ícone -->
                    <x-button-edit href="{{ route('events.edit', $event->id) }}" ariaLabel="Editar evento">
                        {{ __('Editar') }}
                    </x-button-edit>

                    <!-- Botão de Excluir com ícone -->
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline-block"
                        onsubmit="return confirm('{{ __('Tem certeza de que deseja excluir este evento?') }}');">
                        @csrf
                        @method('DELETE')
                        <x-button-delete :action="route('events.destroy', $event->id)"
                            confirmMessage="{{ __('Tem certeza de que deseja excluir este evento?') }}">
                            Excluir
                        </x-button-delete>
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
                    <div class="mb-4 flex justify-center">
                        <img src="{{ Str::startsWith($event->photo_path, 'http') ? $event->photo_path : asset($event->photo_path) }}"
                            alt="{{ $event->title }}"
                            class="rounded-lg max-w-md h-auto shadow-sm cursor-pointer object-contain"
                            onclick="openModal('{{ Str::startsWith($event->photo_path, 'http') ? $event->photo_path : asset($event->photo_path) }}')" />
                    </div>
                @endif


                <!-- Detalhes do Evento -->
                <div class="space-y-4">
                    <div class="text-gray-600 space-y-2 text-base">
                        <p><strong>{{ __('Data do Evento: ') }}</strong>
                            {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</p>

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
                        <x-button-share id="shareEventButton" title="Evento: {{ $event->title }}"
                            text="Participe do evento {{ $event->title }} organizado por {{ $event->ong->ong_name }}"
                            url="{{ route('ong-events.show', $event->id) }}" ariaLabel="Compartilhar perfil do evento">
                            {{ __('Compartilhar Evento') }}
                        </x-button-share>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Imagem -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center">
        <div class="relative" onclick="event.stopPropagation()">
            <button onclick="closeModal()" class="absolute top-0 right-0 m-4 text-white text-3xl">&times;</button>
            <img id="modalImage" src="" alt="Imagem em tamanho real"
                class="max-w-full max-h-screen rounded-lg object-contain">
        </div>
    </div>

    <!-- Script para o modal de imagem -->
    <script>
        function openModal(imageUrl) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageUrl;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
        }

        // Fecha o modal ao clicar fora da imagem
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>

    <!-- Script para compartilhar o evento -->
    <script>
        document.getElementById('shareEventButton').addEventListener('click', function() {
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
