<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Sobre o MeAdote
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-8">

                <!-- Seção Introdução do Projeto -->
                <section class="mb-10">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">O Projeto</h3>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        O <strong>MeAdote</strong> é uma plataforma desenvolvida como parte do meu Trabalho de Conclusão de Curso em Análise e Desenvolvimento de Sistemas pela Universidade de Passo Fundo (UPF).
                        A inspiração para esse projeto veio após as trágicas enchentes no Rio Grande do Sul, que resultaram em muitos animais desabrigados.
                        Sempre fui apaixonada por animais, e foi essa paixão que me motivou a criar uma plataforma que conecte pets em situação de vulnerabilidade com pessoas dispostas a adotá-los e oferecer um novo lar cheio de amor e cuidado.
                    </p>
                </section>

                <!-- Seção Sobre Mim -->
                <section class="mb-10">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Sobre Mim</h3>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Desde sempre, tive um amor profundo por animais. Atualmente, sou tutora de 7 pets adotados, e eles são minha maior inspiração para criar esta plataforma.
                        Meu maior objetivo com o <strong>MeAdote</strong> é ajudar o máximo de animais possível a encontrarem famílias tão amorosas quanto a minha, proporcionando a eles uma nova chance de felicidade.
                    </p>

                    <!-- Foto dos Pets -->
                    <div class="mt-6">
                        <img src="https://res.cloudinary.com/dq7y3bfzb/image/upload/v1729715330/pets/yxfecx9ip8dar24kfzrm.jpg" alt="Meus 7 Pets Adotados"
                            class="w-full h-auto rounded-lg shadow-lg">
                    </div>
                </section>

                <!-- Seção Links Pessoais -->
                <section class="mb-10">
                    {{-- <h3 class="text-2xl font-semibold text-gray-900 mb-4">Conecte-se Comigo</h3> --}}
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Você pode acompanhar meu trabalho e entrar em contato através das seguintes redes:
                    </p>
                    <ul class="mt-6 space-y-4">
                        <li class="flex items-center">
                            <!-- Ícone GitHub -->
                            <i class="fab fa-github fa-lg text-gray-700 mr-3"></i>
                            <a href="https://github.com/ninaluft" target="_blank" class="text-blue-500 hover:underline text-lg">
                                GitHub
                            </a>
                        </li>
                        <li class="flex items-center">
                            <!-- Ícone LinkedIn -->
                            <i class="fab fa-linkedin fa-lg text-blue-700 mr-3"></i>
                            <a href="https://www.linkedin.com/in/marina-luft-2aa83513a/" target="_blank"
                                class="text-blue-500 hover:underline text-lg">
                                LinkedIn
                            </a>
                        </li>
                        <li class="flex items-center">
                            <!-- Ícone Instagram -->
                            <i class="fab fa-instagram fa-lg text-pink-500 mr-3"></i>
                            <a href="https://www.instagram.com/ninaluft/" target="_blank"
                                class="text-blue-500 hover:underline text-lg">
                                Instagram
                            </a>
                        </li>
                        <li class="flex items-center">
                            <!-- Ícone Email -->
                            <i class="fas fa-envelope fa-lg text-gray-500 mr-3"></i>
                            <span class="text-lg text-gray-600">marinaluft@hotmail.com</span>
                        </li>
                    </ul>
                </section>

                <!-- Botão de Voltar -->
                <div class="mt-8">
                    <a href="{{ route('home') }}"
                        class="inline-block bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 text-lg font-semibold transition">
                        Voltar ao Início
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
