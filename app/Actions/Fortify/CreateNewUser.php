<?php

namespace App\Actions\Fortify;

use App\Models\Ong;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Auth;
use Bissolli\ValidadorCpfCnpj\CPF;
use Bissolli\ValidadorCpfCnpj\CNPJ;
use Carbon\Carbon;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Validação comum para todos os usuários
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'], // Nome de usuário
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'user_type' => ['required', 'in:tutor,ong'],
            'cep' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Validação específica por tipo de usuário
        if ($input['user_type'] === 'tutor') {
            Validator::make($input, [
                'full_name' => ['required', 'string', 'max:255'], // Nome completo
                'date_of_birth' => ['required', 'date'],
                'cpf' => [
                    'required',
                    'string',
                    'max:14',
                    'unique:tutors,cpf',
                    function ($attribute, $value, $fail) {
                        $cpf = new CPF($value);
                        if (!$cpf->isValid()) {
                            $fail('O CPF fornecido não é válido.');
                        }
                    }
                ],
                'temporary_housing' => ['required', 'boolean'],
                'about_me' => ['nullable', 'string', 'max:500'],
            ])->validate();

            $input['date_of_birth'] = Carbon::parse($input['date_of_birth'])->format('Y-m-d');


        } elseif ($input['user_type'] === 'ong') {
            Validator::make($input, [
                'ong_name' => ['required', 'string', 'max:255'],
                'responsible_name' => ['required', 'string', 'max:255'],
                'responsible_cpf' => [
                    'required',
                    'string',
                    'max:14',
                    'unique:ongs,responsible_cpf',
                    function ($attribute, $value, $fail) {
                        $cpf = new CPF($value);
                        if (!$cpf->isValid()) {
                            $fail('O CPF do responsável fornecido não é válido.');
                        }
                    }
                ],
                'cnpj' => [
                    'required',
                    'string',
                    'max:18',
                    'unique:ongs,cnpj',
                    function ($attribute, $value, $fail) {
                        $cnpj = new CNPJ($value);
                        if (!$cnpj->isValid()) {
                            $fail('O CNPJ fornecido não é válido.');
                        }
                    }
                ],
                'phone' => ['required', 'string', 'max:20'],
                'about_ong' => ['nullable', 'string', 'max:500'],
            ])->validate();
        }

        // Criar o usuário com todos os campos necessários
        $user = User::create([
            'name' => $input['name'], // Nome de usuário
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'user_type' => $input['user_type'],
            'cep' => $input['cep'], // Adiciona o CEP
            'city' => $input['city'], // Adiciona a cidade
            'state' => $input['state'], // Adiciona o estado
        ]);

        // Criar registro adicional baseado no tipo de usuário
        if ($input['user_type'] === 'tutor') {
            Tutor::create([
                'user_id' => $user->id,
                'full_name' => $input['full_name'], // Nome completo
                'date_of_birth' => $input['date_of_birth'],
                'cpf' => $input['cpf'],
                'temporary_housing' => $input['temporary_housing'],
                'about_me' => $input['about_me'] ?? null, // Opcional
            ]);
        } elseif ($input['user_type'] === 'ong') {
            Ong::create([
                'user_id' => $user->id,
                'ong_name' => $input['ong_name'],
                'responsible_name' => $input['responsible_name'],
                'responsible_cpf' => $input['responsible_cpf'],
                'cnpj' => $input['cnpj'],
                'phone' => $input['phone'],
                'about_ong' => $input['about_ong'] ?? null, // Opcional
            ]);
        }

        // Autenticar o usuário após o registro
        Auth::login($user);

        // Retornar o objeto do usuário recém-criado
        return $user;
    }
}
