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
        // Common validation for all users
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'user_type' => ['required', 'in:tutor,ong'],
            'cep' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // User-specific validation based on type
        if ($input['user_type'] === 'tutor') {
            Validator::make($input, [
                'full_name' => ['required', 'string', 'max:255'],
                'date_of_birth' => ['required', 'date'],
                'cpf' => [
                    'required',
                    'string',
                    'cpf',
                    'unique:tutors,cpf',
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
                    'cpf',
                    'unique:ongs,responsible_cpf',
                ],
                'cnpj' => [
                    'required',
                    'string',
                    'cnpj',
                    'unique:ongs,cnpj',
                ],
                'phone' => ['required', 'string', 'max:20'],
                'about_ong' => ['nullable', 'string', 'max:500'],
            ])->validate();
        }

        // Create the user
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'user_type' => $input['user_type'],
            'cep' => $input['cep'],
            'city' => $input['city'],
            'state' => $input['state'],
        ]);

        // Create additional record based on user type
        if ($input['user_type'] === 'tutor') {
            Tutor::create([
                'user_id' => $user->id,
                'full_name' => $input['full_name'],
                'date_of_birth' => $input['date_of_birth'],
                'cpf' => $input['cpf'],
                'temporary_housing' => $input['temporary_housing'],
                'about_me' => $input['about_me'] ?? null,
            ]);
        } elseif ($input['user_type'] === 'ong') {
            Ong::create([
                'user_id' => $user->id,
                'ong_name' => $input['ong_name'],
                'responsible_name' => $input['responsible_name'],
                'responsible_cpf' => $input['responsible_cpf'],
                'cnpj' => $input['cnpj'],
                'phone' => $input['phone'],
                'about_ong' => $input['about_ong'] ?? null,
            ]);
        }

        // Authenticate the user after registration
        Auth::login($user);

        return $user;
    }
}
