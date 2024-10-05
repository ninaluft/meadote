<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Tipo de Usuário -->
            <div>
                <x-label for="user_type" value="{{ __('Tipo de Usuário') }}" />
                <select id="user_type"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    name="user_type" required onchange="toggleFields(this.value)">
                    <option value="">{{ __('Selecione o tipo de conta') }}</option>
                    <option value="tutor" {{ old('user_type') == 'tutor' ? 'selected' : '' }}>Tutor</option>
                    <option value="ong" {{ old('user_type') == 'ong' ? 'selected' : '' }}>ONG</option>
                </select>
            </div>


            <!-- Campos Gerais -->
            <div id="form_fields" style="display: none;">
                <!-- Nome de Usuário -->
                <div class="mt-4">
                    <x-label for="name" value="{{ __('Nome de Usuário *') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                        required autofocus autocomplete="name" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email *') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autocomplete="username" />
                </div>

                <!-- Campo de Senha -->
                <div class="relative mt-4">
                    <x-label for="password" value="{{ __('Senha *') }}" />
                    <x-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required
                        autocomplete="new-password" />
                    <x-eye-icon field-id="password" />
                    <div id="password-strength" class="mt-1 text-sm"></div>
                    <div id="password-length-warning" class="mt-1 text-sm text-red-500" style="display: none;">
                        Senha deve ter no mínimo 8 caracteres.
                    </div>
                </div>


                <!-- Confirmação de Senha -->
                <div class="relative mt-4">
                    <x-label for="password_confirmation" value="{{ __('Confirme a Senha *') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-full pr-10" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-eye-icon field-id="password_confirmation" />
                </div>

                <!-- Tutor - Campos Específicos -->
                <div id="tutor_fields" style="display: none;">

                    <!-- Data de Nascimento -->
                    <div class="mt-4">
                        <x-label for="date_of_birth" value="{{ __('Data de Nascimento *') }}" />
                        <x-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth"
                            :value="old('date_of_birth')" required />
                    </div>

                    <!-- CPF -->
                    <div class="mt-4">
                        <x-label for="cpf" value="{{ __('CPF *') }}" />
                        <x-input id="cpf" class="block mt-1 w-full" type="text" name="cpf"
                            :value="old('cpf')" required />
                    </div>


                    <div class="mt-4">
                        <x-label value="{{ __('Dados públicos :') }}" />

                    </div>

                    <!-- Nome Completo -->
                    <div class="mt-4">
                        <x-label for="full_name" value="{{ __('Nome Completo *') }}" />
                        <x-input id="full_name" class="block mt-1 w-full" type="text" name="full_name"
                            :value="old('full_name')" required />
                    </div>


                    <!-- Oferece Lar Temporário -->
                    <div class="mt-4">
                        <x-label for="temporary_housing" value="{{ __('Oferece Lar Temporário?') }}" />
                        <select id="temporary_housing"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            name="temporary_housing">
                            <option value="0" {{ old('temporary_housing') == '0' ? 'selected' : '' }}>Não
                            </option>
                            <option value="1" {{ old('temporary_housing') == '1' ? 'selected' : '' }}>Sim
                            </option>
                        </select>
                    </div>

                    <!-- Sobre Mim (Opcional) -->
                    <div class="mt-4">
                        <x-label for="about_me" value="{{ __('Sobre Mim (Opcional)') }}" />
                        <textarea id="about_me"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            name="about_me">{{ old('about_me') }}</textarea>
                    </div>
                </div>

                <!-- ONG - Campos Específicos -->
                <div id="ong_fields" style="display: none;">

                    <!-- CPF do Responsável -->
                    <div class="mt-4">
                        <x-label for="responsible_cpf" value="{{ __('CPF do Responsável *') }}" />
                        <x-input id="responsible_cpf" class="block mt-1 w-full" type="text" name="responsible_cpf"
                            :value="old('responsible_cpf')" required />
                    </div>

                    <div class="mt-4">
                        <x-label value="{{ __('Dados públicos: ') }}" />

                    </div>


                    <div class="mt-4">
                        <x-label for="responsible_name" value="{{ __('Nome do Responsável *') }}" />
                        <x-input id="responsible_name" class="block mt-1 w-full" type="text"
                            name="responsible_name" :value="old('responsible_name')" required />
                    </div>

                    <!-- Nome da ONG -->
                    <div class="mt-4">
                        <x-label for="ong_name" value="{{ __('Nome da ONG *') }}" />
                        <x-input id="ong_name" class="block mt-1 w-full" type="text" name="ong_name"
                            :value="old('ong_name')" required />
                    </div>


                    <!-- CNPJ -->
                    <div class="mt-4">
                        <x-label for="cnpj" value="{{ __('CNPJ *') }}" />
                        <x-input id="cnpj" class="block mt-1 w-full" type="text" name="cnpj"
                            :value="old('cnpj')" required />
                    </div>

                    <!-- Telefone -->
                    <div class="mt-4">
                        <x-label for="phone" value="{{ __('Telefone *') }}" />
                        <x-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                            :value="old('phone')" required />
                    </div>

                    <!-- Sobre a ONG (Opcional) -->
                    <div class="mt-4">
                        <x-label for="about_ong" value="{{ __('Sobre a ONG (Opcional)') }}" />
                        <textarea id="about_ong"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            name="about_ong">{{ old('about_ong') }}</textarea>
                    </div>
                </div>

                <!-- Campos de CEP, Cidade e Estado -->
                <div class="mt-4">
                    <x-label for="cep" value="{{ __('CEP *') }}" />
                    <x-input id="cep" class="block mt-1 w-full" type="text" name="cep"
                        :value="old('cep')" required />
                </div>

                <div class="mt-4">
                    <x-label for="city" value="{{ __('Cidade *') }}" />
                    <x-input id="city" class="block mt-1 w-full" type="text" name="city"
                        :value="old('city')" readonly />
                </div>

                <div class="mt-4">
                    <x-label for="state" value="{{ __('Estado *') }}" />
                    <x-input id="state" class="block mt-1 w-full" type="text" name="state"
                        :value="old('state')" readonly />
                </div>
            </div>

            <!-- Políticas de Privacidade -->
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />
                            <div class="ml-2">
                                {!! __('Eu aceito os :terms_of_service e :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Termos de Serviço') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('policy.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Política de Privacidade') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <!-- Botão de Registro -->
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Já registrado?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Registrar') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    <!-- Script para alternar os campos com base no tipo de usuário -->
    <script>
        function toggleFields(userType) {
            document.getElementById('form_fields').style.display = 'block';
            document.getElementById('tutor_fields').style.display = userType === 'tutor' ? 'block' : 'none';
            document.getElementById('ong_fields').style.display = userType === 'ong' ? 'block' : 'none';

            // Toggle required attributes for Tutor fields
            if (userType === 'tutor') {
                document.getElementById('full_name').setAttribute('required', 'required');
                document.getElementById('date_of_birth').setAttribute('required', 'required');
                document.getElementById('cpf').setAttribute('required', 'required');

                // Remove required attributes from ONG fields
                document.getElementById('responsible_cpf').removeAttribute('required');
                document.getElementById('ong_name').removeAttribute('required');
                document.getElementById('cnpj').removeAttribute('required');
                document.getElementById('phone').removeAttribute('required');
                document.getElementById('responsible_name').removeAttribute('required');
            }

            // Toggle required attributes for ONG fields
            else if (userType === 'ong') {
                document.getElementById('responsible_cpf').setAttribute('required', 'required');
                document.getElementById('ong_name').setAttribute('required', 'required');
                document.getElementById('cnpj').setAttribute('required', 'required');
                document.getElementById('phone').setAttribute('required', 'required');
                document.getElementById('responsible_name').setAttribute('required', 'required');

                // Remove required attributes from Tutor fields
                document.getElementById('full_name').removeAttribute('required');
                document.getElementById('date_of_birth').removeAttribute('required');
                document.getElementById('cpf').removeAttribute('required');
            }
        }

        // Run toggleFields on page load to handle pre-selected values
        document.addEventListener('DOMContentLoaded', function() {
            const userType = document.getElementById('user_type').value;
            if (userType) {
                toggleFields(userType);
            }
        });
    </script>

    <!-- Script para preenchimento automático do CEP -->
    <script>
        document.getElementById('cep').addEventListener('blur', function() {
            var cep = this.value.replace(/\D/g, '');

            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('city').value = data.localidade;
                            document.getElementById('state').value = data.uf;
                        } else {
                            alert('CEP não encontrado.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar o CEP:', error);
                        alert('Erro ao buscar o CEP.');
                    });
            } else {
                alert('CEP inválido. Certifique-se de que o CEP tenha 8 dígitos.');
            }
        });
    </script>

    <!-- Adicionando as máscaras para CPF, CNPJ, Telefone -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#cpf').mask('000.000.000-00', {
                reverse: true
            });
            $('#responsible_cpf').mask('000.000.000-00', {
                reverse: true
            });
            $('#cnpj').mask('00.000.000/0000-00', {
                reverse: true
            });
            $('#phone').mask('(00) 00000-0000', {
                reverse: false
            });
            $('#cep').mask('00000-000', {
                reverse: false
            });
        });

        function validateCPF(cpf) {
            cpf = cpf.replace(/\D/g, '');
            if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
                return false;
            }

            let sum = 0;
            let remainder;

            for (let i = 1; i <= 9; i++) {
                sum += parseInt(cpf.substring(i - 1, i)) * (11 - i);
            }

            remainder = (sum * 10) % 11;
            if (remainder === 10 || remainder === 11) remainder = 0;
            if (remainder !== parseInt(cpf.substring(9, 10))) return false;

            sum = 0;
            for (let i = 1; i <= 10; i++) {
                sum += parseInt(cpf.substring(i - 1, i)) * (12 - i);
            }

            remainder = (sum * 10) % 11;
            if (remainder === 10 || remainder === 11) remainder = 0;
            return remainder === parseInt(cpf.substring(10, 11));
        }

        function validateCNPJ(cnpj) {
            cnpj = cnpj.replace(/\D/g, '');

            if (cnpj.length !== 14) return false;

            let length = cnpj.length - 2;
            let numbers = cnpj.substring(0, length);
            let digits = cnpj.substring(length);
            let sum = 0;
            let pos = length - 7;

            for (let i = length; i >= 1; i--) {
                sum += numbers.charAt(length - i) * pos--;
                if (pos < 2) pos = 9;
            }

            let result = sum % 11 < 2 ? 0 : 11 - sum % 11;
            if (result !== parseInt(digits.charAt(0))) return false;

            length = length + 1;
            numbers = cnpj.substring(0, length);
            sum = 0;
            pos = length - 7;

            for (let i = length; i >= 1; i--) {
                sum += numbers.charAt(length - i) * pos--;
                if (pos < 2) pos = 9;
            }

            result = sum % 11 < 2 ? 0 : 11 - sum % 11;
            return result === parseInt(digits.charAt(1));
        }

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

    <script>
        // Função para verificar a força da senha em tempo real
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthText = document.getElementById('password-strength');
            const lengthWarning = document.getElementById('password-length-warning');
            let strength = 0;

            // Verifica se a senha possui pelo menos 8 caracteres
            if (password.length < 8) {
                lengthWarning.style.display = 'block';
                strengthText.textContent = ''; // Limpa a mensagem de força enquanto a senha for curta demais
            } else {
                lengthWarning.style.display = 'none';
                if (/[A-Z]/.test(password)) strength++;
                if (/[a-z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[\W_]/.test(password)) strength++;

                switch (strength) {
                    case 1:
                    case 2:
                        strengthText.textContent = 'Senha Fraca';
                        strengthText.style.color = 'red';
                        break;
                    case 3:
                        strengthText.textContent = 'Senha Média';
                        strengthText.style.color = 'orange';
                        break;
                    case 4:
                        strengthText.textContent = 'Senha Forte';
                        strengthText.style.color = 'green';
                        break;
                    default:
                        strengthText.textContent = '';
                }
            }
        });
    </script>


</x-guest-layout>
