<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Sobre o MeAdote
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Seção Introdução do Projeto -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">O Projeto</h3>
                    <p class="text-gray-600">
                        O MeAdote é um projeto desenvolvido para meu TCC em Análise e Desenvolvimento de Sistemas da
                        Universidade de Passo Fundo.
                        A ideia surgiu após as enchentes no Rio Grande do Sul, que deixaram muitos animais desabrigados.
                        Sempre fui apaixonada por animais, e esse projeto foi inspirado no desejo de ajudar esses pets a
                        encontrarem lares amorosos e seguros.
                    </p>
                </div>

                <!-- Seção Sobre Mim -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Sobre Mim</h3>
                    <p class="text-gray-600">
                        Desde que me conheço por gente, sempre tive um amor profundo por animais. Atualmente, sou tutora
                        de 7 pets adotados. Eles são minha maior inspiração
                        para criar esta plataforma. Meu objetivo é ajudar o máximo de animais possível a encontrarem
                        famílias tão amorosas quanto a minha.
                    </p>

                    <!-- Foto dos Pets -->
                    <div class="mt-4">
                        <img src="URL_DA_FOTO_DOS_PETS" alt="Meus 7 Pets Adotados"
                            class="w-full h-auto rounded-lg shadow-md">
                    </div>
                </div>

                <!-- Seção Links Pessoais -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Conecte-se Comigo</h3>
                    <p class="text-gray-600">
                        Acompanhe meu trabalho em minhas redes profissionais:
                    </p>
                    <ul class="mt-4 space-y-2">
                        <li class="flex items-center">
                            <!-- Ícone GitHub -->
                            <i class="fab fa-github fa-lg text-gray-700 mr-2"></i>
                            <a href="https://github.com/ninaluft" target="_blank" class="text-blue-500 hover:underline">
                                GitHub - Meus Projetos
                            </a>
                        </li>
                        <li class="flex items-center">
                            <!-- Ícone LinkedIn -->
                            <i class="fab fa-linkedin fa-lg text-blue-700 mr-2"></i>
                            <a href="https://www.linkedin.com/in/marina-luft-2aa83513a/" target="_blank"
                                class="text-blue-500 hover:underline">
                                LinkedIn - Conecte-se Comigo
                            </a>
                        </li>
                        <li class="flex items-center">
                            <!-- Ícone Instagram -->
                            <i class="fab fa-instagram fa-lg text-pink-500 mr-2"></i>
                            <a href="https://www.instagram.com/ninaluft/" target="_blank"
                                class="text-blue-500 hover:underline">
                                Instagram - Meu Perfil
                            </a>
                        </li>
                    </ul>
                </div>


                <!-- Botão de Voltar -->
                <div class="mt-6">
                    <a href="{{ route('home') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Voltar ao Início</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
