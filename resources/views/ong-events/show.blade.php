<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between items-center max-w-4xl mx-auto px-4 space-y-2 sm:space-y-0">
            <h2 class="font-semibold text-xl sm:text-2xl text-gray-800 leading-tight text-center sm:text-left break-words">
                {{ $event->title }}
            </h2>


            @if (Auth::check() && Auth::user()->user_type === 'ong' && Auth::user()->ong->id === $event->ong_id)
                <div class="flex space-x-2">
                    <x-button-edit href="{{ route('events.edit', $event->id) }}" ariaLabel="Editar evento">
                        {{ __('Editar') }}
                    </x-button-edit>

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
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-4 sm:p-6 space-y-4 sm:space-y-6">
                @if ($event->photo_path)
                    <div class="flex justify-center mb-4">
                        <img src="{{ Str::startsWith($event->photo_path, 'http') ? $event->photo_path : asset($event->photo_path) }}"
                            alt="{{ $event->title }}"
                            class="rounded-lg max-w-full sm:max-w-md h-auto shadow-sm cursor-pointer object-contain"
                            onclick="openModal('{{ Str::startsWith($event->photo_path, 'http') ? $event->photo_path : asset($event->photo_path) }}')" />
                    </div>
                @endif

                <div class="space-y-2 sm:space-y-4 text-center sm:text-left text-gray-600">
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

                <div class="mt-4 text-center sm:text-left">
                    <p><strong>{{ __('Organizador do Evento: ') }}</strong>
                        <a href="{{ route('user.public-profile', $event->ong->user->id) }}"
                            class="text-indigo-600 hover:underline"
                            aria-label="Visualizar perfil público de {{ $event->ong->ong_name }}">
                            {{ $event->ong->ong_name }}
                        </a>
                    </p>
                </div>

                <div class="mt-4 flex justify-center sm:justify-start space-x-3 items-center">
                    <x-button-share id="shareEventButton" title="Evento: {{ $event->title }}"
                        text="Participe do evento {{ $event->title }} organizado por {{ $event->ong->ong_name }}"
                        url="{{ route('ong-events.show', $event->id) }}" ariaLabel="Compartilhar perfil do evento">
                        {{ __('Compartilhar Evento') }}
                    </x-button-share>
                </div>
            </div>
        </div>
    </div>

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

        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

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
                navigator.clipboard.writeText(shareData.url)
                    .then(() => alert('Link copiado para a área de transferência!'))
                    .catch(err => console.error('Erro ao copiar link: ', err));
            }
        });
    </script>
</x-app-layout>
