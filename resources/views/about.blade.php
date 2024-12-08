<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.11/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.11/dist/js/splide.min.js"></script>

    <div class="container">
        <x-slot name="header">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Sobre o MeAdote <button id="show-pets-button" class="pet-button">🐶</button>
            </h2>
        </x-slot>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg p-8">

                    <!-- Seção Introdução do Projeto -->
                    <section class="mb-10">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">O Projeto</h3>
                        <p class="text-lg text-gray-600 leading-relaxed text-indent">
                            O <strong>MeAdote</strong> é uma plataforma desenvolvida como parte do meu Trabalho de
                            Conclusão
                            de Curso em Análise e Desenvolvimento de Sistemas pela Universidade de Passo Fundo (UPF).
                        </p>
                        <p class="text-lg text-gray-600 leading-relaxed text-indent">
                            Inspirado pelas trágicas enchentes no Rio Grande do Sul, o projeto visa conectar animais
                            desabrigados com famílias interessadas em adotá-los, oferecendo uma nova chance de vida para
                            esses pets em
                            situação de vulnerabilidade.
                        </p><br>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">Funcionalidades</h3>
                        <p class="text-lg text-gray-600 leading-relaxed text-indent">
                            Na plataforma, usuários podem criar uma conta como ONG ou Tutor para cadastrar animais
                            disponíveis para adoção, favoritar pets, buscar lares temporários, buscar ONG's cadastradas,
                            divulgar eventos e conversar
                            com outros usuários para esclarecer dúvidas. </p>

                        <p class="text-lg text-gray-600 leading-relaxed text-indent">
                            Para adotar um pet, o usuário preenche um
                            formulário que é enviado ao responsável pelo animal,
                            que pode avaliar o perfil do candidato e decidir pela aceitação ou rejeição da adoção.</p>
                        <p class="text-lg text-gray-600 leading-relaxed text-indent">Além
                            disso, o MeAdote conta com um blog gerenciado pelo administrador,
                            com conteúdos sobre adoção e bem-estar animal, além de um painel de controle administrativo
                            para
                            gerenciar a plataforma e responder a solicitações de suporte.</p>

                    </section>

                    <!-- Seção Tecnologias Utilizadas -->
                    <section class="mb-10">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">Tecnologias Utilizadas</h3>
                        <p class="text-lg text-gray-600 leading-relaxed text-indent">
                            A plataforma foi desenvolvida com <strong>PHP</strong> e <strong>Laravel</strong>,
                            utilizando
                            <strong> Inertia.js e Tailwind CSS</strong> para o frontend, e <strong>MySQL</strong> como banco de dados.

                            Para gerenciamento de imagens, integrei a API do <strong>Cloudinary</strong>, garantindo
                            armazenamento seguro e acessível para fotos dos pets e eventos. Isso permite uma experiência
                            otimizada, com carregamento rápido de imagens e manutenção da performance do site.
                        </p>

                    </section>

                    <!-- Seção Segurança e Verificação de Imagens -->
                    <section class="mb-10">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">Segurança e Verificação de Imagens</h3>
                        <p class="text-lg text-gray-600 leading-relaxed text-indent">
                            Para oferecer um ambiente seguro, o <strong>MeAdote</strong> utiliza uma API de verificação
                            de
                            imagens do <strong>Clarifai</strong>, que filtra conteúdos inapropriados antes de serem
                            exibidos publicamente. Esse
                            recurso
                            é fundamental para manter a plataforma focada no bem-estar dos animais e proteger os
                            usuários
                            contra conteúdos indesejados.
                        </p>
                    </section>



                    <!-- Seção de Chamada para Ação -->
                    <section class="mt-10">
                        <p class="text-center text-lg text-gray-600 leading-relaxed">
                            <strong> Fique à vontade para criar uma conta e explorar as funcionalidades
                                oferecidas!<br></strong>
                        </p>
                        <p class="text-lg text-gray-600 leading-relaxed">

                            <br> Caso tenha alguma dúvida ou encontre algum erro, não hesite em me contatar:
                        </p>
                        <div class="mt-6 flex flex-wrap justify-center space-x-4">
                            <a href="https://github.com/ninaluft" target="_blank"
                                class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition transform hover:scale-105 flex items-center mb-2">
                                <i class="fab fa-github fa-lg mr-2"></i> GitHub
                            </a>
                            <a href="https://www.linkedin.com/in/marina-luft-2aa83513a/" target="_blank"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-500 transition transform hover:scale-105 flex items-center mb-2">
                                <i class="fab fa-linkedin fa-lg mr-2"></i> LinkedIn
                            </a>
                            <a href="mailto:marinaluft@hotmail.com"
                                class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition transform hover:scale-105 flex items-center mb-2">
                                <i class="fas fa-envelope fa-lg mr-2"></i> Email
                            </a>
                        </div>
                    </section>

                    <!-- Botão de Voltar -->
                    <div class="mt-8 text-center">
                        <a href="{{ route('home') }}"
                            class="inline-block bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 text-lg font-semibold transition transform hover:scale-105">
                            Voltar ao Início
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contêiner fixo para os emojis -->
    <div id="pets-container"></div>

    <!-- CSS adicional para estilos dos pets -->
    <style>
        .container {
            overflow: hidden;
        }

        .pet-button {
            font-size: 40px;
            background: none;
            border: none;
            cursor: pointer;
            margin: 20px;
        }

        .pet-button:focus {
            outline: none;
        }

        #pets-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            /* Evita interferência na interação do usuário */
            overflow: hidden;
            z-index: 9999;
            /* Garante que os emojis fiquem no topo */
        }

        .pet {
            font-size: 40px;
            position: absolute;
            transition: opacity 2s linear, transform 5s linear;
        }
    </style>

    <script>
        const petEmojis = ["🐶", "🐱", "🐰", "🐕", "🐕‍🦺", "🐷", "🐇", "🐭", "🐮", "🐾", "🐎"];
        const maxPets = 60;
        const petsContainer = document.getElementById('pets-container');
        const showPetsButton = document.getElementById('show-pets-button');

        if (showPetsButton) {
            showPetsButton.addEventListener('click', createPets);
        }

        function createPets() {


            for (let i = 0; i < maxPets; i++) {
                createPet();
            }
        }

        function createPet() {
            const pet = document.createElement('div');
            pet.textContent = petEmojis[Math.floor(Math.random() * petEmojis.length)];
            pet.classList.add('pet');
            pet.style.opacity = '0';

            const rotation = Math.floor(Math.random() * 41) - 20;
            pet.style.transform = `rotate(${rotation}deg)`;
            petsContainer.appendChild(pet);

            const randomCoordinate = getRandomCoordinate();
            animatePet(pet, randomCoordinate);
        }



        function getRandomCoordinate() {
            const screenWidth = window.innerWidth;
            const screenHeight = window.innerHeight;
            const buffer = 50;

            const side = Math.floor(Math.random() * 4);
            let x, y;

            switch (side) {
                case 0:
                    x = Math.random() * (screenWidth - buffer * 2) + buffer;
                    y = 0 - buffer;
                    break;
                case 1:
                    x = screenWidth - buffer;
                    y = Math.random() * (screenHeight - buffer * 2) + buffer;
                    break;
                case 2:
                    x = Math.random() * (screenWidth - buffer * 2) + buffer;
                    y = screenHeight - buffer;
                    break;
                case 3:
                    x = 0 - buffer;
                    y = Math.random() * (screenHeight - buffer * 2) + buffer;
                    break;
                default:
                    x = screenWidth / 2;
                    y = screenHeight / 2;
            }

            return {
                x,
                y
            };
        }

        function animatePet(pet, randomCoordinate) {
            const centerX = window.innerWidth / 2 - 50;
            const centerY = window.innerHeight / 2 - 50;
            const randomDestination = getRandomCoordinate();
            const randomDelay = Math.random() * 2000;
            const transitionDuration = '5s';

            pet.style.width = '100px';
            pet.style.height = '100px';
            pet.style.position = 'absolute';
            pet.style.left = `${randomCoordinate.x}px`;
            pet.style.top = `${randomCoordinate.y}px`;

            setTimeout(() => {
                pet.style.transition = `opacity 2s linear, transform ${transitionDuration} linear`;
                pet.style.opacity = '1';
                pet.style.transform =
                    `translate(${randomDestination.x - centerX}px, ${randomDestination.y - centerY}px)`;
            }, 100);

            setTimeout(() => {
                pet.style.transition = `transform ${transitionDuration} linear, opacity 1s linear`;
                pet.style.opacity = '0';
                setTimeout(() => pet.remove(), 5000); // Remove após a animação
            }, randomDelay + 2000);
        }
    </script>
</x-app-layout>
