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
                            <img id="photo-preview"
                                @if ($user->profile_photo) src="{{ $user->profile_photo }}" @endif
                                alt="{{ $user->name }}"
                                class="rounded-full h-32 w-32 object-cover @if (!$user->profile_photo) hidden @endif">

                            <x-input id="profile_photo" type="file" name="profile_photo" class="mt-1 block w-full"
                                onchange="previewImage(event)" />
                        </div>

                        @if ($user->profile_photo)
                            <div class="mt-2">
                                <x-checkbox id="remove_photo" name="remove_photo" value="1" />
                                <x-label for="remove_photo" :value="__('Não exibir foto de perfil')" />
                            </div>
                        @endif

                        @error('profile_photo')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Modal para o Croppie -->
                    <div id="cropperModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
                        <div class="flex items-center justify-center min-h-screen px-4">
                            <div
                                class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-3xl w-full p-6">
                                <h2 class="text-lg font-semibold mb-4">Ajuste a Imagem de Perfil</h2>
                                <div id="cropperContainer" class="mb-4"></div>
                                <div class="flex justify-end mt-4">
                                    <button type="button" id="cropButton"
                                        class="bg-blue-500 text-white px-4 py-2 rounded-md">Cortar e Salvar</button>
                                    <button type="button" onclick="closeCropperModal()"
                                        class="ml-4 bg-red-500 text-white px-4 py-2 rounded-md">Cancelar</button>
                                </div>
                            </div>
                        </div>
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

                            <!-- Limite de caracteres -->
                            <textarea id="about_me" name="about_me" rows="6" maxlength="900"
                                class="form-input rounded-md shadow-sm mt-1 block w-full" oninput="updateCharacterCount()">{{ old('about_me', $user->tutor->about_me) }}</textarea>

                            <!-- Exibição da contagem de caracteres -->
                            <small id="charCount" class="text-gray-600">900 caracteres restantes</small>

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

                            <!-- Limite de caracteres -->
                            <textarea id="about_ong" name="about_ong" rows="6" maxlength="900"
                                class="form-input rounded-md shadow-sm mt-1 block w-full" oninput="updateOngCharacterCount()">{{ old('about_ong', $user->ong->about_ong) }}</textarea>

                            <!-- Exibição da contagem de caracteres -->
                            <small id="ongCharCount" class="text-gray-600">900 caracteres restantes</small>

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
                    <!-- Campo para adicionar links de redes sociais -->
                    <div class="mb-6">
                        <x-label for="social_links" :value="__('Links de Redes Sociais')" />
                        <div id="social-links-container" class="space-y-2">
                            <!-- Exibir links já salvos no banco de dados -->
                            @foreach ($socialNetworks as $social)
                                <div class="flex items-center space-x-2">
                                    <x-input type="url" name="social_links[{{ $social->id }}]"
                                        value="{{ $social->profile_url }}" class="w-full"
                                        placeholder="Cole o link da rede social aqui" />
                                    <button type="button"
                                        onclick="removeExistingSocialLink({{ $social->id }}, this)"
                                        class="bg-red-500 text-white px-2 rounded">X</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addNewSocialLink()"
                            class="mt-2 bg-blue-500 text-white px-2 py-2 rounded">+ Adicionar Rede Social</button>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">{{ __('Salvar') }}</x-button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <link rel="stylesheet" href="https://unpkg.com/croppie/croppie.css" />
    <script src="https://unpkg.com/croppie/croppie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- Script para visualizar a imagem selecionada -->
    <!-- Script para visualizar a imagem selecionada com Croppie -->
    <script>
        var croppie;

        document.getElementById('profile_photo').addEventListener('change', function(event) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Mostra a prévia da imagem e abre o modal do Croppie
                document.getElementById('photo-preview').src = e.target.result;
                document.getElementById('photo-preview').classList.remove('hidden');
                openCropperModal();

                // Inicializa o Croppie
                var el = document.getElementById('cropperContainer');
                if (croppie) {
                    croppie.destroy();
                }
                croppie = new Croppie(el, {
                    viewport: {
                        width: 200,
                        height: 200,
                        type: 'circle'
                    },
                    boundary: {
                        width: 300,
                        height: 300
                    },
                    showZoomer: true,
                    enableOrientation: true
                });

                croppie.bind({
                    url: e.target.result
                });
            };
            reader.readAsDataURL(event.target.files[0]);
        });

        function openCropperModal() {
            document.getElementById('cropperModal').classList.remove('hidden');
        }

        function closeCropperModal() {
            document.getElementById('cropperModal').classList.add('hidden');
        }

        document.getElementById('cropButton').addEventListener('click', function() {
            croppie.result({
                type: 'blob',
                size: {
                    width: 200,
                    height: 200
                }
            }).then(function(blob) {
                const url = URL.createObjectURL(blob);
                document.getElementById('photo-preview').src = url;

                // Crie um novo objeto File para enviar ao backend
                const fileInput = document.getElementById('profile_photo');
                const dataTransfer = new DataTransfer();
                const file = new File([blob], 'cropped-profile-photo.png', {
                    type: 'image/png'
                });
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;

                closeCropperModal();
            });
        });
    </script>




    <script>
        function buscarCEP(cep) {
            // Remove qualquer caractere não numérico antes de continuar
            cep = cep.replace(/\D/g, '');

            if (cep !== "") {
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


    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const socialLinks = document.querySelectorAll('input[type="url"]');

            socialLinks.forEach((input) => {
                input.addEventListener('blur', function() {
                    if (this.value && !/^https?:\/\//i.test(this.value)) {
                        this.value = `http://${this.value}`;
                    }
                });
            });
        });

        function addNewSocialLink() {
            const container = document.getElementById('social-links-container');
            const inputDiv = document.createElement('div');
            inputDiv.className = 'flex items-center space-x-2';
            inputDiv.innerHTML = `
            <x-input type="url" name="new_social_links[]" class="w-full" placeholder="Cole o link completo da rede social aqui" />
            <button type="button" onclick="removeNewSocialLink(this)" class="bg-red-500 text-white px-2 rounded">X</button>
        `;
            container.appendChild(inputDiv);
        }

        function removeNewSocialLink(button) {
            const inputDiv = button.parentNode;
            inputDiv.remove();
        }

        function removeExistingSocialLink(id, button) {
            const inputDiv = button.parentNode;
            // Adiciona um campo oculto para marcar o link como excluído ao submeter o formulário
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'deleted_social_links[]';
            hiddenInput.value = id;
            inputDiv.appendChild(hiddenInput);
            // Esconde o campo visualmente
            inputDiv.style.display = 'none';
        }
    </script>

    <!-- Script para atualizar a contagem de caracteres -->
    <script>
        function updateCharacterCount() {
            const textarea = document.getElementById('about_me');

            // Verifica se o campo existe antes de tentar acessar suas propriedades
            if (textarea) {
                const charCountDisplay = document.getElementById('charCount');
                const maxLength = textarea.getAttribute('maxlength');
                const currentLength = textarea.value.length;

                charCountDisplay.textContent = `${maxLength - currentLength} caracteres restantes`;
            }
        }

        // Inicializa a contagem de caracteres ao carregar a página, apenas se o campo existir
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('about_me');
            if (textarea) {
                updateCharacterCount();
            }
        });
    </script>

    <!-- Script para atualizar a contagem de caracteres -->
    <script>
        function updateOngCharacterCount() {
            const textarea = document.getElementById('about_ong');

            // Verifica se o campo existe antes de tentar acessar suas propriedades
            if (textarea) {
                const charCountDisplay = document.getElementById('ongCharCount');
                const maxLength = textarea.getAttribute('maxlength');
                const currentLength = textarea.value.length;

                charCountDisplay.textContent = `${maxLength - currentLength} caracteres restantes`;
            }
        }

        // Inicializa a contagem de caracteres ao carregar a página, apenas se o campo existir
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('about_ong');
            if (textarea) {
                updateOngCharacterCount();
            }
        });











        // Função para validar o CPF
        function validarCPF(cpf) {
            cpf = cpf.replace(/[^\d]+/g, '');
            if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;
            let soma = 0,
                resto;
            for (let i = 1; i <= 9; i++) soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
            resto = (soma * 10) % 11;
            if ((resto === 10) || (resto === 11)) resto = 0;
            if (resto !== parseInt(cpf.substring(9, 10))) return false;
            soma = 0;
            for (let i = 1; i <= 10; i++) soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
            resto = (soma * 10) % 11;
            if ((resto === 10) || (resto === 11)) resto = 0;
            return resto === parseInt(cpf.substring(10, 11));
        }

        // Evento de validação ao sair do campo CPF
        document.getElementById('cpf').addEventListener('blur', function() {
            const cpf = this.value;
            const cpfError = document.getElementById('cpfError');

            if (!validarCPF(cpf)) {
                cpfError.style.display = 'block';
                this.classList.add('border-red-500');
            } else {
                cpfError.style.display = 'none';
                this.classList.remove('border-red-500');
            }
        });
    </script>



</x-app-layout>
