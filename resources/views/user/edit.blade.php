<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Perfil') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">
                    {{ __('Informações do Perfil') }}
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    {{ __('Atualize as informações do perfil e o endereço de e-mail da sua conta.') }}
                </p>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                    onsubmit="return validateForm()">
                    @csrf
                    @method('PUT')

                    <!-- Foto de Perfil -->
                    <div class="mb-6">
                        <x-label for="profile_photo" :value="__('Foto de Perfil')" />
                        <div class="flex items-center space-x-6 mt-2">
                            <!-- Prévia da Nova Imagem -->
                            <img id="photo-preview" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                class="rounded-full h-32 w-32 object-cover">

                            <x-input id="profile_photo" type="file" name="profile_photo" class="mt-1 block w-full"
                                onchange="previewImage(event)" />
                        </div>
                        @if ($user->profile_photo_path)
                            <div class="mt-2">
                                <x-checkbox id="remove_photo" name="remove_photo" value="1" />
                                <x-label for="remove_photo" :value="__('Remover a foto de perfil atual')" />
                            </div>
                        @endif
                        @error('profile_photo')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nome -->
                    <div class="mb-6">
                        <x-label for="name" :value="__('Nome de usuário')" />
                        <x-input id="name" type="text" name="name" :value="old('name', $user->name)"
                            class="mt-1 block w-full" required />
                        @error('name')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <hr class="my-6 border-gray-300">

                    <!-- Email -->
                    <div class="mb-6">
                        <x-label for="email" :value="__('E-mail')" />
                        <x-input id="email" type="email" name="email" :value="old('email', $user->email)"
                            class="mt-1 block w-full" required />
                        @error('email')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Renderização Condicional para Tutor ou ONG -->
                    @if ($user->user_type === 'tutor')
                        <!-- Nome Completo (Tutor) -->
                        <div class="mb-6">
                            <x-label for="full_name" :value="__('Nome Completo')" />
                            <x-input id="full_name" type="text" name="full_name" :value="old('full_name', $user->tutor->full_name)"
                                class="mt-1 block w-full" required />
                            @error('full_name')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Data de Nascimento (Tutor) -->
                        <div class="mb-6">
                            <x-label for="date_of_birth" :value="__('Data de Nascimento')" />
                            <x-input id="date_of_birth" type="date" name="date_of_birth" :value="old('date_of_birth', $user->tutor->date_of_birth)"
                                class="mt-1 block w-full" required />
                            @error('date_of_birth')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- CPF (Tutor) -->
                        <div class="mb-6">
                            <x-label for="cpf" :value="__('CPF')" />
                            <x-input id="cpf" type="text" name="cpf" :value="old('cpf', $user->tutor->cpf)"
                                class="mt-1 block w-full" required />
                            @error('cpf')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Lar Temporário (Tutor) -->
                        <div class="mb-6">
                            <x-label for="temporary_housing" :value="__('Lar Temporário')" />
                            <!-- Campo hidden para garantir o valor false se o checkbox estiver desmarcado -->
                            <input type="hidden" name="temporary_housing" value="0">
                            <div class="flex items-center mt-2">
                                <input type="checkbox" id="temporary_housing" name="temporary_housing" value="1"
                                    @if (old('temporary_housing', $user->tutor->temporary_housing)) checked @endif>
                                <x-label for="temporary_housing" :value="__('Ofereço Lar Temporário')" class="ml-2" />
                            </div>
                            @error('temporary_housing')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>


                        <!-- Sobre Mim (Tutor) -->
                        <div class="mb-6">
                            <x-label for="about_me" :value="__('Sobre Mim')" />
                            <textarea id="about_me" name="about_me" class="form-input rounded-md shadow-sm mt-1 block w-full">{{ old('about_me', $user->tutor->about_me) }}</textarea>
                            @error('about_me')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif ($user->user_type === 'ong')
                        <!-- Nome da ONG -->
                        <div class="mb-6">
                            <x-label for="ong_name" :value="__('Nome da ONG')" />
                            <x-input id="ong_name" type="text" name="ong_name" :value="old('ong_name', $user->ong->ong_name)"
                                class="mt-1 block w-full" required />
                            @error('ong_name')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Telefone (ONG) -->
                        <div class="mb-6">
                            <x-label for="phone" :value="__('Telefone')" />
                            <x-input id="phone" type="text" name="phone" :value="old('phone', $user->ong->phone)"
                                class="mt-1 block w-full" required />
                            @error('phone')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nome do Responsável (ONG) -->
                        <div class="mb-6">
                            <x-label for="responsible_name" :value="__('Nome do Responsável')" />
                            <x-input id="responsible_name" type="text" name="responsible_name" :value="old('responsible_name', $user->ong->responsible_name)"
                                class="mt-1 block w-full" required />
                            @error('responsible_name')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- CPF do Responsável (ONG) -->
                        <div class="mb-6">
                            <x-label for="responsible_cpf" :value="__('CPF do Responsável')" />
                            <x-input id="responsible_cpf" type="text" name="responsible_cpf" :value="old('responsible_cpf', $user->ong->responsible_cpf)"
                                class="mt-1 block w-full" required />
                            @error('responsible_cpf')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>


                        <!-- CNPJ (ONG) -->
                        <div class="mb-6">
                            <x-label for="cnpj" :value="__('CNPJ')" />
                            <x-input id="cnpj" type="text" name="cnpj" :value="old('cnpj', $user->ong->cnpj)"
                                class="mt-1 block w-full" required />
                            @error('cnpj')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Sobre a ONG -->
                        <div class="mb-6">
                            <x-label for="about_ong" :value="__('Sobre a ONG')" />
                            <textarea id="about_ong" name="about_ong" class="form-input rounded-md shadow-sm mt-1 block w-full">{{ old('about_ong', $user->ong->about_ong) }}</textarea>
                            @error('about_ong')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <!-- CEP -->
                    <div class="mb-6">
                        <x-label for="cep" :value="__('CEP')" />
                        <x-input id="cep" type="text" name="cep" :value="old('cep', $user->cep)"
                            class="mt-1 block w-full" required onblur="buscarCEP(this.value)" />
                        @error('cep')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Cidade -->
                    <div class="mb-6">
                        <x-label for="city" :value="__('Cidade')" />
                        <x-input id="city" type="text" name="city" :value="old('city', $user->city)"
                            class="mt-1 block w-full" />
                        @error('city')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div class="mb-6">
                        <x-label for="state" :value="__('Estado')" />
                        <x-input id="state" type="text" name="state" :value="old('state', $user->state)"
                            class="mt-1 block w-full" />
                        @error('state')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">{{ __('Atualizar Perfil') }}</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para visualizar a imagem selecionada -->
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('photo-preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <!-- Script da API ViaCEP e de validações -->
    <script>
        function buscarCEP(cep) {
            cep = cep.replace(/\D/g, '');

            if (cep != "") {
                const validacep = /^[0-9]{8}$/;

                if (validacep.test(cep)) {
                    const script = document.createElement('script');
                    script.src = `https://viacep.com.br/ws/${cep}/json/?callback=preencherEndereco`;
                    document.body.appendChild(script);
                } else {
                    alert("Formato de CEP inválido.");
                }
            }
        }

        function preencherEndereco(dados) {
            if (!("erro" in dados)) {
                document.getElementById('city').value = dados.localidade;
                document.getElementById('state').value = dados.uf;
            } else {
                alert("CEP não encontrado.");
            }
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function() {
            // Mascara para CPF
            $('#cpf').mask('000.000.000-00', {
                reverse: true
            });

            // Mascara para CNPJ
            $('#cnpj').mask('00.000.000/0000-00', {
                reverse: true
            });
        });

        function validateForm() {
            const cpf = $('#cpf').val();
            const cnpj = $('#cnpj').val();

            if (cpf && !validateCPF(cpf)) {
                alert("CPF inválido.");
                return false;
            }

            if (cnpj && !validateCNPJ(cnpj)) {
                alert("CNPJ inválido.");
                return false;
            }

            return true;
        }
    </script>
</x-app-layout>
