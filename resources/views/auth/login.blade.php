<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            @if (isset($redirectTo))
                <input type="hidden" name="redirectTo" value="{{ $redirectTo }}">
            @endif


            <div>
                <x-label for="email" value="{{ __('auth.email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
            </div>

            <!-- Campo de Senha -->
            <div class="relative mt-4">
                <x-label for="password" value="{{ __('Senha') }}" />
                <div class="flex items-center">
                    <x-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-eye-icon field-id="password" />
                </div>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('auth.remember_me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4 w-full">
                <div class="flex flex-col">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                            {{ __('auth.forgot_password') }}
                        </a>
                    @endif

                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mt-1"
                        href="{{ route('register') }}">
                        {{ __('Não possui conta? Registre-se') }}
                    </a>
                </div>

                <x-button class="ml-4">
                    {{ __('auth.log_in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>