<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center max-w-4xl mx-auto px-4">
            <!-- Título -->
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight break-words sm:break-all">
                Perfil de {{ $user->name }}
            </h2>

            <!-- Botão para Editar Perfil -->
            @if (Auth::check() && Auth::id() === $user->id)
                <div>
                    <x-button-edit href="{{ route('profile.edit') }}" ariaLabel="Editar perfil" icon="fas fa-edit"
                        color="yellow" class="flex items-center justify-center w-12 h-12 sm:w-auto sm:h-auto sm:p-1">
                        <!-- Show text only on larger screens -->
                        <span >Editar Perfil</span>
                    </x-button-edit>
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
                        @if (!empty($user->profile_photo))
                            <!-- Usando x-image para exibir a foto de perfil -->
                            <x-image :src="$user->profile_photo" alt="Foto de perfil de {{ $user->name }}"
                                class="rounded-full w-40 h-40 md:w-48 md:h-48 object-cover" />
                        @else
                            <!-- Exibir as iniciais caso a foto de perfil não esteja disponível -->
                            <x-initials-avatar :user="$user" />
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
                            <p><strong>Redes sociais:</strong></p>
                            <div class="flex space-x-4 mt-2">
                                @foreach ($socialNetworks as $social)
                                    <a href="{{ $social->profile_url }}" target="_blank"
                                        aria-label="Acessar perfil no {{ $social->platform_name }}">
                                        @switch($social->platform_name)
                                            @case('Facebook')
                                                <i class="fab fa-facebook fa-2x text-blue-600" aria-hidden="true"></i>
                                            @break

                                            @case('Twitter')
                                                <i class="fab fa-twitter fa-2x text-blue-400" aria-hidden="true"></i>
                                            @break

                                            @case('Instagram')
                                                <i class="fab fa-instagram fa-2x text-pink-500" aria-hidden="true"></i>
                                            @break

                                            @case('LinkedIn')
                                                <i class="fab fa-linkedin fa-2x text-blue-700" aria-hidden="true"></i>
                                            @break

                                            @default
                                                <span>Acessar link externo</span>
                                        @endswitch
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Botões de Ação -->
                    <div class="mt-8 flex flex-col sm:flex-row items-center sm:space-x-4 space-y-4 sm:space-y-0">

                        <!-- Botão para Compartilhar o Perfil -->
                        <x-button-share id="shareProfileButton" title="Perfil de {{ $user->name }}"
                            text="Veja o perfil de {{ $user->name }} no nosso site."
                            url="{{ route('user.public-profile', $user->id) }}"
                            ariaLabel="Compartilhar o perfil de {{ $user->name }}">
                            {{ __('Compartilhar Perfil') }}
                        </x-button-share>



                        <x-button icon="fas fa-envelope" color="green"
                            href="{{ Auth::check() ? route('messages.conversation', $user->id) : route('login', ['redirectTo' => route('messages.conversation', $user->id)]) }}"
                            ariaLabel="Enviar mensagem para {{ $user->name }}">
                            Enviar Mensagem
                        </x-button>

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
        document.getElementById('shareProfileButton').addEventListener('click', function() {
            const shareData = {
                title: 'Perfil de {{ $user->name }}',
                text: 'Veja o perfil público de {{ $user->name }} no MeAdote.',
                url: '{{ route('user.public-profile', $user->id) }}'
            };

            if (navigator.share) {
                navigator.share(shareData)
                    .then(() => console.log('Perfil compartilhado com sucesso'))
                    .catch((error) => console.log('Erro ao compartilhar:', error));
            } else {
                // Fallback para copiar o link para a área de transferência
                navigator.clipboard.writeText(shareData.url)
                    .then(() => alert('Link copiado para a área de transferência!'))
                    .catch(err => console.error('Erro ao copiar link: ', err));
            }
        });
    </script>

</x-app-layout>
