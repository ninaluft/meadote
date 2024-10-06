<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard do Administrador') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Métricas de Solicitações de Suporte -->
            <div>
                <a href="{{ route('admin.support.index') }}">
                    <div class="bg-white shadow-md rounded-lg p-6">

                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Solicitações de Suporte</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Gerenciamento de Usuários -->
                <a href="{{ route('admin.manage-users') }}"
                    class="block bg-white shadow-md rounded-lg p-6 text-center hover:bg-teal-100 transition duration-200 ease-in-out">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Total Usuários</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $usersCount }}</p>
                </a>

                <!-- Gerenciamento de Pets -->
                <a href="{{ route('admin.manage-pets') }}"
                    class="block bg-white shadow-md rounded-lg p-6 text-center hover:bg-teal-100 transition duration-200 ease-in-out">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Total Pets</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $petsCount }}</p>
                </a>

                <!-- Gerenciamento de Eventos -->
                <a href="{{ route('admin.manage-events') }}"
                    class="block bg-white shadow-md rounded-lg p-6 text-center hover:bg-teal-100 transition duration-200 ease-in-out">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Total Eventos</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $eventsCount }}</p>
                </a>

                <!-- Gerenciamento de Formulários -->
                <a href="{{ route('admin.manage-forms') }}"
                    class="block bg-white shadow-md rounded-lg p-6 text-center hover:bg-teal-100 transition duration-200 ease-in-out">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Total Formulários</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $formsCount }}</p>
                </a>
            </div>

            <!-- Botão Criar Novo Post -->
            <div class="block space-x-4">
                <a href="{{ route('posts.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 ease-in-out inline-block">
                    {{ __('Criar Novo Post no Blog') }}
                </a>
                <a href="{{ route('faqs.edit') }}"
                    class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200 ease-in-out inline-block">
                    {{ __('Editar FAQs') }}
                </a>
            </div>




        </div>
    </div>
</x-app-layout>
