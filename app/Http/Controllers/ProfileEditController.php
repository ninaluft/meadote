<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;
use Bissolli\ValidadorCpfCnpj\CPF;
use Bissolli\ValidadorCpfCnpj\CNPJ;

class ProfileEditController extends Controller
{
    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        // Base validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'profile_photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
            'cep' => ['nullable', 'string', 'max:14'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
        ];

        // Conditionally add validation rules based on user type
        if ($user->user_type === 'tutor') {
            // Additional validation for Tutor
            $rules = array_merge($rules, [
                'full_name' => ['required', 'string', 'max:255'],
                'date_of_birth' => ['required', 'date'],
                'cpf' => [
                    'required',
                    'string',
                    'max:14',
                    Rule::unique('tutors', 'cpf')->ignore($user->tutor->id),
                    function($attribute, $value, $fail) {
                        $cpf = new CPF($value);
                        if (!$cpf->isValid()) {
                            $fail('O CPF fornecido não é válido.');
                        }
                    },
                ],
                'temporary_housing' => ['boolean'],
                'about_me' => ['nullable', 'string', 'max:1000'],
            ]);
        } elseif ($user->user_type === 'ong') {
            // Additional validation for ONG
            $rules = array_merge($rules, [
                'ong_name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:20'],
                'responsible_name' => ['required', 'string', 'max:255'],
                'responsible_cpf' => [
                    'required',
                    'string',
                    'max:14',
                    Rule::unique('ongs', 'responsible_cpf')->ignore($user->ong->id),
                    function($attribute, $value, $fail) {
                        $cpf = new CPF($value);
                        if (!$cpf->isValid()) {
                            $fail('O CPF do responsável fornecido não é válido.');
                        }
                    },
                ],
                'cnpj' => [
                    'required',
                    'string',
                    'max:18',
                    Rule::unique('ongs', 'cnpj')->ignore($user->ong->id),
                    function($attribute, $value, $fail) {
                        $cnpj = new CNPJ($value);
                        if (!$cnpj->isValid()) {
                            $fail('O CNPJ fornecido não é válido.');
                        }
                    },
                ],
                'about_ong' => ['nullable', 'string', 'max:1000'],
            ]);
        }

        // Validate the request
        $request->validate($rules);

        // Handle profile photo removal
        if ($request->has('remove_photo') && $request->input('remove_photo') == 1) {
            $user->deleteProfilePhoto(); // Jetstream method to remove the photo
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $user->updateProfilePhoto($request->file('profile_photo')); // Jetstream's update method
        }

        // Update base user profile fields
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'cep' => $request->input('cep'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
        ]);

        // Update additional fields based on user type
        if ($user->user_type === 'tutor') {
            // Update Tutor-specific fields
            $user->tutor->update([
                'full_name' => $request->input('full_name'),
                'date_of_birth' => $request->input('date_of_birth'),
                'cpf' => $request->input('cpf'),
                'temporary_housing' => $request->input('temporary_housing'),
                'about_me' => $request->input('about_me'),
            ]);
        } elseif ($user->user_type === 'ong') {
            // Update ONG-specific fields
            $user->ong->update([
                'ong_name' => $request->input('ong_name'),
                'phone' => $request->input('phone'),
                'responsible_name' => $request->input('responsible_name'),
                'responsible_cpf' => $request->input('responsible_cpf'),
                'cnpj' => $request->input('cnpj'),
                'about_ong' => $request->input('about_ong'),
            ]);
        }

        return redirect()->route('profile.edit')->with('status', 'Perfil atualizado com sucesso!');
    }
}
