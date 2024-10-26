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
                        O <strong>MeAdote</strong> é uma plataforma desenvolvida como parte do meu Trabalho de Conclusão
                        de Curso em Análise e Desenvolvimento de Sistemas pela Universidade de Passo Fundo (UPF).
                        Inspirado pelas trágicas enchentes no Rio Grande do Sul, o projeto visa conectar animais
                        desabrigados com famílias interessadas em adotá-los, oferecendo uma nova chance de vida para esses pets em
                        situação de vulnerabilidade.
                    </p><br>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Na plataforma, usuários podem criar uma conta como ONG ou tutor para cadastrar animais
                        disponíveis para adoção, favoritar pets, buscar lares temporários, divulgar eventos e conversar
                        com outros usuários para esclarecer dúvidas. Para adotar um pet, o usuário preenche um formulário que é enviado ao responsável pelo animal,
                        que pode avaliar o perfil do candidato e decidir pela aceitação ou rejeição da adoção. Além disso, o MeAdote conta com um blog gerenciado pelo administrador,
                        com conteúdos sobre adoção e bem-estar animal, além de um painel de controle para gerenciar a plataforma e responder a solicitações de suporte.
                    </p>
                </section>

                <!-- Seção Tecnologias Utilizadas -->
                <section class="mb-10">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Tecnologias Utilizadas</h3>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        A plataforma foi desenvolvida com <strong>PHP</strong> e <strong>Laravel</strong>, utilizando
                       <strong> Blade</strong> para o frontend, e <strong>MySQL</strong> como banco de dados.
                    </p>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Para gerenciamento de imagens, integrei a API do <strong>Cloudinary</strong>, garantindo
                        armazenamento seguro e acessível para fotos dos pets e eventos. Isso permite uma experiência
                        otimizada, com carregamento rápido de imagens e manutenção da performance do site.
                    </p>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        O <strong>MeAdote</strong> foi desenvolvido como uma <strong>Progressive Web App (PWA)</strong>, tornando a plataforma acessível em dispositivos móveis
                        com uma experiência de uso fluida e responsiva, como em um aplicativo nativo. Isso significa que a aplicação se adapta automaticamente a diferentes tamanhos de tela,
                        permitindo que os usuários acessem todas as funcionalidades a partir de qualquer dispositivo, como smartphones, tablets ou desktops, de forma prática e intuitiva.
                    </p>
                </section>

                <!-- Seção Segurança e Verificação de Imagens -->
                <section class="mb-10">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Segurança e Verificação de Imagens</h3>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Para oferecer um ambiente seguro, o <strong>MeAdote</strong> utiliza uma API de verificação de
                        imagens que filtra conteúdos inapropriados antes de serem exibidos publicamente. Esse recurso
                        é fundamental para manter a plataforma focada no bem-estar dos animais e proteger os usuários
                        contra conteúdos indesejados.
                    </p>
                </section>

                <!-- Seção Sobre Mim -->
                <section class="mb-10">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Sobre Mim</h3>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Desde sempre, tive um grande amor por animais. Atualmente, sou tutora de 7 pets adotados, que
                        foram minha maior inspiração para criar esta plataforma e contribuir para que outros animais
                        encontrem lares amorosos.
                    </p>

                    <!-- Foto dos Pets -->
                    <div class="mt-6">
                        <img src="https://res.cloudinary.com/dq7y3bfzb/image/upload/v1729715330/pets/yxfecx9ip8dar24kfzrm.jpg"
                            alt="Meus 7 Pets Adotados" class="w-full h-auto rounded-lg shadow-lg">
                    </div>
                </section>

                <!-- Seção Links Pessoais -->
                <section class="mb-10">
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Fique à vontade para criar uma conta e explorar as funcionalidades oferecidas!
                        <br><br> Caso tenha alguma dúvida ou encontre algum erro,
                        não exite em me contatar:
                    </p>
                    <ul class="mt-6 space-y-4">
                        <li class="flex items-center">
                            <i class="fab fa-github fa-lg text-gray-700 mr-3"></i>
                            <a href="https://github.com/ninaluft" target="_blank"
                                class="text-blue-500 hover:underline text-lg">
                                GitHub
                            </a>
                        </li>
                        <li class="flex items-center">
                            <i class="fab fa-linkedin fa-lg text-blue-700 mr-3"></i>
                            <a href="https://www.linkedin.com/in/marina-luft-2aa83513a/" target="_blank"
                                class="text-blue-500 hover:underline text-lg">
                                LinkedIn
                            </a>
                        </li>
                        <li class="flex items-center">
                            <i class="fab fa-instagram fa-lg text-pink-500 mr-3"></i>
                            <a href="https://www.instagram.com/ninaluft/" target="_blank"
                                class="text-blue-500 hover:underline text-lg">
                                Instagram
                            </a>
                        </li>
                        <li class="flex items-center">
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
