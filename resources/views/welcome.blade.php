<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Bem-vindo ao MeAdote!') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">

                <!-- Seção de Introdução -->
                <div class="mb-12 text-center">
                    <h3 class="font-semibold text-2xl mb-4">{{ __('O Que Fazemos') }}</h3>
                    <p class="text-gray-700 text-lg">Conectamos famílias amorosas com pets que precisam de um lar.</p>
                </div>

                <!-- Seção de Exploração -->
                <div class="mb-12 text-center">
                    <h3 class="font-semibold text-2xl mb-4">{{ __('Explore Nossa Plataforma') }}</h3>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('pets.all-pets') }}"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                            {{ __('Buscar Pets') }}
                        </a>
                        <a href="{{ Auth::check() ? route('pets.create') : route('login', ['redirectTo' => route('pets.create')]) }}"
                            class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                            {{ __('Cadastrar Pets') }}
                        </a>


                    </div>
                </div>

                <!-- Seção de Chamada para Ação -->
                <div class="mb-12 text-center">
                    <h3 class="font-semibold text-2xl mb-4">{{ __('Junte-se a Nós') }}</h3>
                    <p class="text-gray-700 text-lg mb-6">Crie uma conta e comece a fazer a diferença.</p>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('register') }}"
                            class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                            {{ __('Cadastrar-se') }}
                        </a>
                        <a href="{{ route('login') }}"
                            class="bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition">
                            {{ __('Entrar') }}
                        </a>
                    </div>
                </div>

                <!-- Seção de Depoimentos ou Histórias de Sucesso -->
                <div class="text-center">
                    <h3 class="font-semibold text-2xl mb-4">{{ __('Histórias de Sucesso') }}</h3>
                    <p class="text-gray-700 text-lg mb-6">Leia sobre adoções bem-sucedidas e eventos impactantes de
                        ONGs.</p>
                    <!-- Exemplos de Histórias de Sucesso -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-4">
                        <div class="p-6 border rounded-lg shadow-lg bg-gray-50 hover:bg-gray-100 transition">
                            <h4 class="font-semibold text-xl mb-2">{{ __('Família Feliz e Bella') }}</h4>
                            <p class="text-gray-700">A Bella encontrou seu lar definitivo após passar meses em um abrigo
                                de uma ONG. Agora, ela é um membro feliz da família Smith!</p>
                        </div>
                        <div class="p-6 border rounded-lg shadow-lg bg-gray-50 hover:bg-gray-100 transition">
                            <h4 class="font-semibold text-xl mb-2">{{ __('Evento de ONG Bem-Sucedido') }}</h4>
                            <p class="text-gray-700">Nossa ONG parceira organizou uma campanha de vacinação para animais
                                de rua, ajudando mais de 100 pets a receber os cuidados que precisavam.</p>
                        </div>
                        <div class="p-6 border rounded-lg shadow-lg bg-gray-50 hover:bg-gray-100 transition">
                            <h4 class="font-semibold text-xl mb-2">{{ __('Novo Lar para Max') }}</h4>
                            <p class="text-gray-700">Max finalmente encontrou uma nova casa amorosa! Ele agora vive
                                feliz com sua nova família que o adora.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
