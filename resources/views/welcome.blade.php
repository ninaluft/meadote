<x-app-layout>

    <!-- Import Swiper.js CSS and JS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <div class="py-8 bg-[#e7edee] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-10">

                <!-- Seção de Introdução -->
                <div class="mb-12 text-center">
                    <h3 class="font-extrabold text-4xl text-gray-800 mb-4">{{ __('Bem-vindo ao MeAdote!') }}</h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Aqui conectamos famílias amorosas com pets que precisam de um lar. Junte-se a nós e faça a
                        diferença!
                    </p>
                </div>

                <!-- Seção de Exploração -->
                <div class="mb-8 text-center">
                    <h3 class="font-bold text-3xl text-gray-800 mb-6">{{ __('Explore Nossa Plataforma:') }}</h3>
                    <div class="flex flex-wrap justify-center gap-6 mt-4">
                        <a href="{{ route('pets.all-pets') }}"
                            class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition shadow-lg hover:shadow-xl w-full sm:w-auto">
                            {{ __('Buscar Pets') }}
                        </a>
                        <a href="{{ Auth::check() ? route('pets.create') : route('login', ['redirectTo' => route('pets.create')]) }}"
                            class="bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-700 transition shadow-lg hover:shadow-xl w-full sm:w-auto">
                            {{ __('Cadastrar Pets') }}
                        </a>
                        <a href="{{ route('ongs.index') }}"
                            class="bg-orange-500 text-white px-6 py-3 rounded-full hover:bg-orange-600 transition shadow-lg hover:shadow-xl w-full sm:w-auto">
                            {{ __('Buscar ONGs') }}
                        </a>
                        <a href="{{ route('ong-events.index') }}"
                            class="bg-purple-600 text-white px-6 py-3 rounded-full hover:bg-purple-700 transition shadow-lg hover:shadow-xl w-full sm:w-auto">
                            {{ __('Buscar Eventos') }}
                        </a>
                    </div>
                </div>

                <!-- Carrossel de Últimos Posts -->
                <div class="container mx-auto py-2 relative mb-8">
                    <div class="swiper mySwiper rounded-lg overflow-hidden">
                        <!-- Altura aumentada -->
                        <div class="swiper-wrapper">
                            @foreach ($posts as $post)
                                <div class="swiper-slide flex flex-col bg-white rounded-lg shadow-md p-4 hover:shadow-xl transition-transform transform hover:scale-105"
                                    style="height: 360px;">
                                    <a href="{{ route('posts.index') }}"
                                        class="block text-gray-800 hover:text-gray-800 no-underline h-full">
                                        <h3 class="text-xl font-semibold mb-2">{{ $post->title }}</h3>

                                        @if ($post->image_path)
                                            <div class="flex-shrink-0 mb-2">
                                                <img src="{{ asset('storage/' . $post->image_path) }}"
                                                    alt="{{ $post->title }}"
                                                    class="w-full h-60 object-cover rounded-lg shadow-sm">
                                                <!-- Altura aumentada -->
                                            </div>
                                        @endif

                                        <div class="text-gray-600 text-base leading-relaxed overflow-hidden"
                                            style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">
                                            {!! \Illuminate\Support\Str::limit($post->content, 150) !!}
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination mt-0"></div>
                    </div>
                </div>


                <!-- Seção de Chamada para Ação -->
                <div class="mb-12 text-center">
                    <h3 class="font-bold text-3xl text-gray-800 mb-4">{{ __('Junte-se a Nós') }}</h3>
                    <p class="text-gray-600 text-lg leading-relaxed mb-6">
                        Crie uma conta e comece a fazer a diferença na vida dos animais.
                    </p>
                    <div class="flex justify-center space-x-6">
                        <a href="{{ route('register') }}"
                            class="bg-red-400 text-white px-6 py-3 rounded-full hover:bg-red-500 transition shadow-lg hover:shadow-xl">
                            {{ __('Cadastrar-se') }}
                        </a>
                        <a href="{{ route('login') }}"
                            class="bg-yellow-500 text-white px-6 py-3 rounded-full hover:bg-yellow-600 transition shadow-lg hover:shadow-xl">
                            {{ __('Entrar') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Initialize Swiper.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var swiper = new Swiper('.mySwiper', {
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                spaceBetween: 20,
                slidesPerView: 1,
            });
        });
    </script>
</x-app-layout>
