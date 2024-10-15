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
                    <x-button-edit href="{{ route('profile.edit') }}" ariaLabel="Editar perfil" icon="fas fa-edit"
                        color="yellow" size="sm">
                        Editar Perfil
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
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos() && !empty($user->profile_photo_path))
                            <img src="{{ $user->profile_photo_url }}" alt="Foto de perfil de {{ $user->name }}"
                                class="rounded-full w-40 h-40 md:w-48 md:h-48 object-cover">
                        @else
                            <span
                                class="inline-flex items-center justify-center h-16 w-16 md:h-20 md:w-20 rounded-full bg-gray-500"
                                aria-label="Imagem de perfil indisponível, mostrando iniciais de {{ $user->name }}">
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
                        <x-button-share id="shareProfileButton" title="Perfil de {{ $user->name }}"
                            text="Veja o perfil de {{ $user->name }} no nosso site."
                            url="{{ route('user.public-profile', $user->id) }}"
                            ariaLabel="Compartilhar o perfil de {{ $user->name }}">
                            {{ __('Compartilhar Perfil') }}
                        </x-button-share>


                        <!-- Botão para Enviar Mensagem -->
                        @if (Auth::check() && Auth::id() !== $user->id)
                            <x-button icon="fas fa-envelope" color="green"
                                href="{{ route('messages.conversation', $user->id) }}"
                                ariaLabel="Enviar mensagem para {{ $user->name }}">
                                Enviar Mensagem
                            </x-button>
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
        function sharePet() {
            if (navigator.share) {
                navigator.share({
                    title: 'Perfil de {{ $user->name }}',
                    text: 'Veja o perfil público de {{ $user->name }} no MeAdote.',
                    url: window.location.href
                }).then(() => {
                    console.log('Perfil compartilhado com sucesso');
                }).catch((error) => {
                    console.error('Erro ao compartilhar:', error);
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Link copiado para a área de transferência!');
                }).catch((error) => {
                    console.error('Erro ao copiar link: ', error);
                });
            }
        }
        document.getElementById('shareButton').addEventListener('click', sharePet);
    </script>

</x-app-layout>