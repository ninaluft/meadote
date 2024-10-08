<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center max-w-4xl mx-auto px-4">
            <!-- Título -->
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight break-words break-all">
                Perfil de
                @if ($user->user_type === 'ong' || $user->user_type === 'admin')
                    {{ $profileData ? $profileData->ong_name : 'Informações não disponíveis' }}
                @elseif ($user->user_type === 'tutor')
                    {{ $profileData ? $profileData->full_name : $user->name }}
                @endif
            </h2>

            <!-- Botão para Editar Perfil -->
            @if (Auth::check() && Auth::id() === $user->id)
                <div>
                    <a href="{{ route('profile.edit') }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-2 rounded-md flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.232a2.121 2.121 0 113 3L7.5 20.5l-4 1 1-4L16.732 3.732z" />
                        </svg>
                        Editar Perfil
                    </a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-4 lg:px-6">

            <div class="bg-white shadow-md rounded-lg p-6">
                <!-- Verificar o tipo de perfil: ONG ou Tutor -->
                <div class="container mx-auto py-6">

                    <!-- Exibir a Foto de Perfil -->
                    <div class="flex items-center space-x-4 md:space-x-6 mb-6">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos() && !empty($user->profile_photo_path))
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                class="rounded-full w-40 h-40 md:w-48 md:h-48 object-cover">
                        @else
                            <span
                                class="inline-flex items-center justify-center h-16 w-16 md:h-20 md:w-20 rounded-full bg-gray-500">
                                <span class="text-lg md:text-xl font-medium leading-none text-white">
                                    @if ($user->user_type === 'ong' || $user->user_type === 'admin')
                                        {{ strtoupper(substr($profileData->ong_name ?? 'Informação', 0, 1)) }}
                                    @elseif ($user->user_type === 'tutor')
                                        {{ strtoupper(substr($profileData->full_name ?? 'Informação', 0, 1)) }}
                                    @else
                                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr($user->last_name ?? '', 0, 1)) }}
                                    @endif
                                </span>
                            </span>
                        @endif

                        <div>
                            <h2 class="text-lg md:text-xl font-bold text-gray-700">
                                @if ($user->user_type === 'ong' || $user->user_type === 'admin')
                                    {{ $profileData ? $profileData->ong_name : 'Informações não disponíveis' }}
                                @elseif ($user->user_type === 'tutor')
                                    {{ $profileData ? $profileData->full_name : $user->name }}
                                @endif
                            </h2>
                            <p class="text-sm md:text-base">
                                {{ $user->user_type === 'ong' || $user->user_type === 'admin' ? 'ONG' : 'Tutor' }}
                            </p>
                            <p class="text-sm text-gray-500">{{ $user->city }}, {{ $user->state }}</p>
                        </div>
                    </div>

                    <!-- Exibir dados específicos de ONG ou Tutor -->
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        @if ($user->user_type === 'ong' || $user->user_type === 'admin')
                            @if ($profileData)
                                <div class="space-y-3">
                                    <p><strong>Nome do Responsável:</strong> {{ $profileData->responsible_name }}</p>
                                    <p><strong>Telefone:</strong> {{ $profileData->phone }}</p>
                                    <p><strong>CNPJ:</strong> {{ $profileData->cnpj }}</p>
                                    <p><strong>Sobre a ONG:</strong> </p>
                                    <p class="leading-normal">{!! nl2br(e($profileData->about_ong)) !!}</p>
                                </div>
                            @else
                                <p>Informações não disponíveis.</p>
                            @endif
                        @elseif ($user->user_type === 'tutor')
                            @if ($profileData)
                                <div class="space-y-3">
                                    <p><strong>Sobre Mim:</strong></p>
                                    <p class="mt-2 whitespace-pre-wrap">{!! nl2br(e($profileData->about_me)) !!}</p>
                                </div>
                            @else
                                <p>Informações não disponíveis.</p>
                            @endif
                        @endif
                    </div>

                    <!-- Redes Sociais -->
                    @if ($socialNetworks->isNotEmpty())
                        <div class="mt-8">
                            <p><strong>Redes socias:</strong>
                            <div class="flex space-x-4 mt-2">
                                @foreach ($socialNetworks as $social)
                                    <a href="{{ $social->profile_url }}" target="_blank">
                                        @switch($social->platform_name)
                                            @case('Facebook')
                                                <i class="fab fa-facebook fa-2x text-blue-600"></i>
                                            @break

                                            @case('Twitter')
                                                <i class="fab fa-twitter fa-2x text-blue-400"></i>
                                            @break

                                            @case('Instagram')
                                                <i class="fab fa-instagram fa-2x text-pink-500"></i>
                                            @break

                                            @case('LinkedIn')
                                                <i class="fab fa-linkedin fa-2x text-blue-700"></i>
                                            @break

                                            @default
                                                <span>Rede não identificada</span>
                                        @endswitch
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Botões de Ação -->
                    <div class="mt-8 flex flex-col sm:flex-row items-center sm:space-x-4 space-y-4 sm:space-y-0">
                        <!-- Botão para Compartilhar o Perfil -->
                        <button type="button"
                            class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md flex items-center justify-center"
                            id="shareButton">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                            </svg>
                            {{ __('pets.share') }}
                        </button>

                        <!-- Botão para Enviar Mensagem -->
                        @if (Auth::check() && Auth::id() !== $user->id)
                            <a href="{{ route('messages.conversation', $user->id) }}"
                                class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md flex items-center justify-center shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 7.5l8.25 5.25L20.25 7.5m-16.5 0v9a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0020.25 16.5v-9m-16.5 0l8.25 5.25L20.25 7.5" />
                                </svg>
                                Enviar Mensagem
                            </a>
                        @endif
                    </div>

                    <!-- Exibir os Pets cadastrados pelo usuário -->
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Pets Cadastrados pelo usuário</h3>

                        @if ($pets->isNotEmpty())
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($pets as $pet)
                                    <a href="{{ route('pets.show', $pet->id) }}"
                                        class="block hover:shadow-lg transition-shadow duration-300">
                                        <x-pet-card :pet="$pet" />
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600">O usuário não possui nenhum pet cadastrado disponível para
                                adoção.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para API de Compartilhamento -->
    <script>
        document.getElementById('shareButton').addEventListener('click', async () => {
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: 'Perfil de {{ $user->user_type === 'ong' || $user->user_type === 'admin' ? ($profileData ? $profileData->ong_name : 'Informações não disponíveis') : ($profileData ? $profileData->full_name : $user->name) }}',
                        text: 'Veja o perfil público de {{ $user->user_type === 'ong' || $user->user_type === 'admin' ? ($profileData ? $profileData->ong_name : 'Informações não disponíveis') : ($profileData ? $profileData->full_name : $user->name) }} no MeAdote.',
                        url: window.location.href
                    });
                } catch (error) {
                    console.log('Erro ao compartilhar:', error);
                }
            } else {
                // Fallback para copiar o link se o navegador não suportar a API de Compartilhamento
                try {
                    await navigator.clipboard.writeText(window.location.href);
                    alert('Link copiado para a área de transferência!');
                } catch (error) {
                    console.log('Erro ao copiar o link:', error);
                }
            }
        });
    </script>
</x-app-layout>
