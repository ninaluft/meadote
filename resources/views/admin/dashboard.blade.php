<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Painel do Administrador') }}
            </h2>

            <!-- Menu Suspenso -->
            <div class="relative">
                <button class="bg-gray-800 text-white px-4 py-2 rounded-lg focus:outline-none" id="menuButton">
                    {{ __('Opções de Edição') }}
                </button>

                <!-- Dropdown Menu -->
                <div id="menuDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                    <a href="{{ route('posts.create') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">{{ __('Criar Novo Post no Blog') }}</a>
                    <a href="{{ route('faqs.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">{{ __('Editar FAQs') }}</a>
                    <a href="{{ route('admin.terms.edit', 1) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">{{ __('Editar Termos de Uso') }}</a>
                    <a href="{{ route('admin.policy.edit', 1) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">{{ __('Editar Política de Privacidade') }}</a>
                    <a href="{{ route('admin.footer.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">{{ __('Editar Rodapé') }}</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <!-- Métricas de Solicitações de Suporte -->
            <div>
                <a href="{{ route('admin.support.index') }}">
                    <div class="bg-white shadow-lg rounded-xl p-8 hover:shadow-2xl transition duration-300 ease-in-out">
                        <h3 class="text-2xl font-semibold text-gray-700 mb-6">Solicitações de Suporte</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="bg-gray-100 p-6 rounded-lg shadow-inner text-center">
                                <p class="text-gray-600">Total de Solicitações</p>
                                <p class="text-3xl font-bold text-indigo-600">{{ $totalRequestsCount }}</p>
                            </div>
                            <div class="bg-green-100 p-6 rounded-lg shadow-inner text-center">
                                <p class="text-gray-600">Solicitações Abertas</p>
                                <p class="text-3xl font-bold text-green-600">{{ $openRequestsCount }}</p>
                            </div>
                            <div class="bg-red-100 p-6 rounded-lg shadow-inner text-center">
                                <p class="text-gray-600">Solicitações Fechadas</p>
                                <p class="text-3xl font-bold text-red-600">{{ $closedRequestsCount }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Seções de Gerenciamento -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Gerenciamento de Usuários -->
                <a href="{{ route('admin.manage-users') }}"
                    class="block bg-white shadow-lg rounded-xl p-8 text-center hover:bg-teal-100 transition duration-300 ease-in-out">
                    <h3 class="text-2xl font-semibold text-gray-700 mb-2">Total Usuários</h3>
                    <p class="text-4xl font-bold text-gray-800">{{ $usersCount }}</p>
                </a>

                <!-- Gerenciamento de Pets -->
                <a href="{{ route('admin.manage-pets') }}"
                    class="block bg-white shadow-lg rounded-xl p-8 text-center hover:bg-teal-100 transition duration-300 ease-in-out">
                    <h3 class="text-2xl font-semibold text-gray-700 mb-2">Total Pets</h3>
                    <p class="text-4xl font-bold text-gray-800">{{ $petsCount }}</p>
                </a>

                <!-- Gerenciamento de Eventos -->
                <a href="{{ route('admin.manage-events') }}"
                    class="block bg-white shadow-lg rounded-xl p-8 text-center hover:bg-teal-100 transition duration-300 ease-in-out">
                    <h3 class="text-2xl font-semibold text-gray-700 mb-2">Total Eventos</h3>
                    <p class="text-4xl font-bold text-gray-800">{{ $eventsCount }}</p>
                </a>

                <!-- Gerenciamento de Formulários -->
                <a href="{{ route('admin.manage-forms') }}"
                    class="block bg-white shadow-lg rounded-xl p-8 text-center hover:bg-teal-100 transition duration-300 ease-in-out">
                    <h3 class="text-2xl font-semibold text-gray-700 mb-2">Total Formulários</h3>
                    <p class="text-4xl font-bold text-gray-800">{{ $formsCount }}</p>
                </a>
            </div>

            
        </div>
    </div>


    <!-- Script para Mostrar/Ocultar Menu Dropdown -->
    <script>
        const menuButton = document.getElementById('menuButton');
        const menuDropdown = document.getElementById('menuDropdown');

        menuButton.addEventListener('click', () => {
            menuDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!menuButton.contains(event.target) && !menuDropdown.contains(event.target)) {
                menuDropdown.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
