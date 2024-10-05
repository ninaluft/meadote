<x-app-layout>

    <!-- Import Swiper.js CSS and JS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <div class="py-8 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#a1b9b638] overflow-hidden shadow-xl sm:rounded-lg p-10">

                {{-- bg-[#d4e2e4] --}}

                <!-- Seção de Introdução -->
                <div class="mb-8 text-center">
                    <h3 class="font-semibold text-2xl mb-2">{{ __('Bem-vindo ao MeAdote!') }}</h3>
                    <p class="text-gray-700 text-lg">Aqui conectamos famílias amorosas com pets que precisam de um lar.
                    </p>
                </div>

                <!-- Seção de Exploração -->
                <div class="mb-4 text-center">
                    <h3 class="font-semibold text-2xl mb-2">{{ __('Explore Nossa Plataforma:') }}</h3>
                    <div class="flex flex-wrap justify-center gap-4 mt-4">
                        <a href="{{ route('pets.all-pets') }}"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition w-full sm:w-auto">
                            {{ __('Buscar Pets') }}
                        </a>
                        <a href="{{ Auth::check() ? route('pets.create') : route('login', ['redirectTo' => route('pets.create')]) }}"
                            class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition w-full sm:w-auto">
                            {{ __('Cadastrar Pets') }}
                        </a>
                        <a href="{{ route('ongs.index') }}"
                            class="bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 transition w-full sm:w-auto">
                            {{ __('Buscar ONGs') }}
                        </a>
                        <a href="{{ route('ong-events.index') }}"
                            class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition w-full sm:w-auto">
                            {{ __('Buscar Eventos') }}
                        </a>
                        {{-- <a href="{{ route('temporary-housing.index') }}"
                        class="bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition w-full sm:w-auto">
                        {{ __('Buscar Lar Temporário') }} --}}
                    </a>
                    </div>
                </div>


                <!-- Carrossel de Últimos Posts -->
                <div class="container mx-auto py-8">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach ($posts as $post)
                                <div class="swiper-slide p-6 border rounded-lg shadow-lg bg-[#f0f1f1] transition">
                                    <a href="{{ route('posts.index') }}"
                                        class="block text-gray-800 hover:text-gray-800 no-underline">
                                        <h3 class="text-2xl font-bold mb-2">{{ $post->title }}</h3>

                                        @if ($post->image_path)
                                            <img src="{{ asset('storage/' . $post->image_path) }}"
                                                alt="{{ $post->title }}"
                                                class="w-full h-48 object-cover mb-4 rounded-lg">
                                        @endif
                                        <div class="text-gray-700">
                                            {!! \Illuminate\Support\Str::limit($post->content, 150) !!}
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

                <!-- Seção de Chamada para Ação -->
                <div class="mb-12 text-center">
                    <h3 class="font-semibold text-2xl mb-2">{{ __('Junte-se a Nós') }}</h3>
                    <p class="text-gray-700 text-lg mb-4">Crie uma conta e comece a fazer a diferença.</p>
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

            </div>
        </div>
    </div>

    <!-- Initialize Swiper.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var swiper = new Swiper('.mySwiper', {
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                spaceBetween: 30,
            });
        });
    </script>
</x-app-layout>
