<nav x-data="{ open: false }" class="bg-white border-b border-gray-100" aria-label="Navegação Principal">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/icons/icon-64x64.png') }}" alt="Logotipo">
                    </a>
                </div>

                @if (Auth::check())
                    <!-- Navigation Links -->
                    <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex mt-6 ml-2 mr-4 sm:items-center ">
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard') ||
                            request()->routeIs('tutor.dashboard') ||
                            request()->routeIs('ong.dashboard') ||
                            request()->routeIs('admin.dashboard')" aria-label="Painel">
                            {{ __('Meu Painel') }}
                        </x-nav-link>

                    </div>
                @endif

            </div>



            <div class="hidden sm:flex sm:items-center sm:ms-4  ">
                @auth
                    <!-- All Pets -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                        <x-nav-link :href="route('pets.all-pets')" :active="request()->routeIs('pets.all-pets')" aria-label="Todos os Pets">
                            {{ __('Pets para adoção') }}
                        </x-nav-link>
                    </div>


                    <!-- Visualizar Todas as ONGs -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                        <x-nav-link :href="route('ongs.index')" :active="request()->routeIs('ongs.index')" aria-label="ONGs">
                            {{ __('ONGs') }}
                        </x-nav-link>
                    </div>

                    <!-- View Events -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                        <x-nav-link :href="route('ong-events.index')" :active="request()->routeIs('ong-events.index')" aria-label="Ver Eventos">
                            {{ __('Eventos') }}
                        </x-nav-link>
                    </div>

                    <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                        <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.index')" aria-label="Blog">
                            {{ __('Blog') }}
                        </x-nav-link>
                    </div>


                    <!-- Messages Link with Notification Icon -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center ">
                        <x-nav-link :href="route('messages.inbox')" :active="request()->routeIs('messages.inbox')" aria-label="Mensagens">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 text-teal-600 hover:text-teal-700 transition duration-150 ease-in-out"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>

                            @if (auth()->user()->unreadMessages()->count() > 0)
                                <span class="ml-1 inline-block bg-red-600 text-white text-xs rounded-full px-2 py-1">
                                    {{ auth()->user()->unreadMessages()->count() }}
                                </span>
                            @endif
                        </x-nav-link>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button aria-label="Configurações da Conta"
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-10 w-10 rounded-full object-cover"
                                            src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ Auth::user()->name }}
                                            <svg class="ms-2 -me-0.5 h-4 w-4 stroke-teal-600"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>

                                        </button>
                                    </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link href="{{ route('user.public-profile', Auth::id()) }}">
                                    {{ __('Meu perfil') }}
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Configurações de conta') }}
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('support.index') }}">
                                    {{ __('Suporte') }}
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('faqs.show') }}">
                                    {{ __('FAQs') }}
                                </x-dropdown-link>

                                <div class="border-t border-gray-200"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        {{ __('Sair') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endauth

                @guest
                    <!-- Blog -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10  sm:flex">
                        <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.index')" aria-label="Blog">
                            {{ __('Blog') }}
                        </x-nav-link>
                    </div>

                    <!-- Login and Register Links for Guests -->
                    <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')" aria-label="Fazer Login">
                        {{ __('Login') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')" aria-label="Registrar-se">
                        {{ __('Registrar-se') }}
                    </x-nav-link>
                @endguest

            </div>


            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">

                <!-- Add Messages Icon for Mobile -->
                @auth

                    <x-nav-link :href="route('messages.inbox')" :active="request()->routeIs('messages.inbox')" aria-label="Mensagens">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-teal-600 hover:text-teal-700 transition duration-150 ease-in-out"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>

                        @if (auth()->user()->unreadMessages()->count() > 0)
                            <span class="ml-1 inline-block bg-red-600 text-white text-xs rounded-full px-2 py-1">
                                {{ auth()->user()->unreadMessages()->count() }}
                            </span>
                        @endif
                    </x-nav-link>

                @endauth

                <button @click="open = ! open" aria-expanded="false" aria-label="Abrir Menu"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6 stroke-teal-600 hover:stroke-teal-700 transition duration-150 ease-in-out"
                        fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>
            </div>
        </div>
    </div>


    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }"
        class="hidden sm:hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-40"
        aria-label="Menu Responsivo">


        <!-- Conteúdo do Menu -->
        <div
            class="bg-white w-3/4 h-full p-4 shadow-md z-50 absolute right-0 top-0 transition duration-300 ease-in-out">

            <!-- Botão Fechar -->
            <div class="flex justify-end">
                <button @click="open = false" aria-label="Fechar Menu" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            @auth
                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-b border-gray-200">
                    <div class="flex items-center px-4">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <div class="shrink-0 me-3">
                                <img class="h-10 w-10 rounded-full object-cover"
                                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </div>
                        @endif

                        <div>
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">

                        <div class="mt-3 space-y-1">
                            <!-- Account Management -->

                            <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')"
                                aria-label="Perfil">
                                {{ __('Configurações de Conta') }}
                            </x-responsive-nav-link>

                            <!-- Suporte -->
                            <x-responsive-nav-link href="{{ route('support.index') }}" :active="request()->routeIs('support.user')"
                                aria-label="Minhas Solicitações de Suporte">
                                {{ __('Suporte') }}
                            </x-responsive-nav-link>

                            <!-- FAQS-->
                            <x-responsive-nav-link href="{{ route('posts.faq') }}" :active="request()->routeIs('support.user')"
                                aria-label="Perguntas frequentes">
                                {{ __('FAQs') }}
                            </x-responsive-nav-link>



                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();"
                                    aria-label="Sair">
                                    {{ __('Sair') }}
                                </x-responsive-nav-link>
                            </form>

                            <div class="border-t border-gray-200"></div>


                            <!-- Additional Responsive Links -->

                            <x-responsive-nav-link href="{{ route('pets.all-pets') }}" :active="request()->routeIs('pets.all-pets')"
                                aria-label="Todos os Pets">
                                {{ __('Pets para adoção') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('ongs.index') }}" :active="request()->routeIs('ongs.index')" aria-label="ONGs">
                                {{ __('ONGs') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('temporary-housing.index') }}" :active="request()->routeIs('temporary-housing.index')"
                                aria-label="Lar Temporário">
                                {{ __('Lar Temporário') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('ong-events.index') }}" :active="request()->routeIs('ong-events.index')"
                                aria-label="Eventos">
                                {{ __('Eventos') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.index')"
                                aria-label="Blog">
                                {{ __('Blog') }}
                            </x-responsive-nav-link>

                        </div>
                    </div>
                @endauth

                <div class="pt-2 pb-3 space-y-1">
                    <!-- Responsive Links -->
                    @guest
                        <x-responsive-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')" aria-label="Fazer Login">
                            {{ __('Login') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')"
                            aria-label="Registrar-se">
                            {{ __('Registrar-se') }}
                        </x-responsive-nav-link>
                    @endguest
                </div>
            </div>
        </div>
</nav>
