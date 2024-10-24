<?php

namespace App\Http\Controllers;

use App\Models\SocialNetwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileEditController extends Controller
{
    protected $imageService;

    public function __construct(\App\Services\ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $socialNetworks = SocialNetwork::where('user_id', $user->id)->get();
        return view('user.edit', compact('user', 'socialNetworks'));
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
            'profile_photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:5120'],
            'cep' => ['nullable', 'string', 'max:14'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'social_links.*' => ['nullable', 'url', 'max:255'], // Existing social links validation
            'new_social_links.*' => ['nullable', 'url', 'max:255'], // New social links validation
        ];

        // Conditionally add validation rules based on user type
        if ($user->user_type === 'tutor') {
            $rules = array_merge($rules, [
                'full_name' => ['required', 'string', 'max:255'],
                'date_of_birth' => ['required', 'date'],
                'cpf' => [
                    'required',
                    'string',
                    'cpf',
                    Rule::unique('tutors', 'cpf')->ignore($user->tutor->id),
                ],
                'temporary_housing' => ['boolean'],
                'about_me' => ['nullable', 'string', 'max:1000'],
            ]);
        } elseif ($user->user_type === 'ong') {
            $rules = array_merge($rules, [
                'ong_name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:20'],
                'responsible_name' => ['required', 'string', 'max:255'],
                'responsible_cpf' => [
                    'required',
                    'string',
                    'cpf',
                    Rule::unique('ongs', 'responsible_cpf')->ignore($user->ong->id),
                ],
                'cnpj' => [
                    'required',
                    'string',
                    'cnpj',
                    Rule::unique('ongs', 'cnpj')->ignore($user->ong->id),
                ],
                'about_ong' => ['nullable', 'string', 'max:1000'],
            ]);
        }

        // Validate the request
        $request->validate($rules);

        // Handle profile photo removal
        if ($request->has('remove_photo') && $request->input('remove_photo') == 1) {
            // Excluir a imagem do Cloudinary
            if ($user->profile_photo_public_id) {
                $this->imageService->deleteImage($user->profile_photo_public_id);
            }
            // Limpar o campo de imagem no banco de dados
            $user->update(['profile_photo' => null, 'profile_photo_public_id' => null]);
        }

        // Handle profile photo upload
        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Excluir a imagem antiga antes de fazer o upload da nova
            if ($user->profile_photo_public_id) {
                $this->imageService->deleteImage($user->profile_photo_public_id);
            }

            // Fazer o upload da nova imagem usando o ImageService
            $imageData = $this->imageService->uploadImage($request->file('profile_photo')->getRealPath(), 'profile_photos');

            // Verifique se a imagem foi considerada imprópria
            if (isset($imageData['secure_url']) && isset($imageData['public_id'])) {
                // Atualizar o caminho da imagem e o public_id no banco de dados
                $user->update([
                    'profile_photo' => $imageData['secure_url'],
                    'profile_photo_public_id' => $imageData['public_id'],
                ]);
            } else {
                return redirect()->back()->with('error', 'A imagem foi detectada como imprópria.');
            }
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
            $user->tutor->update([
                'full_name' => $request->input('full_name'),
                'date_of_birth' => $request->input('date_of_birth'),
                'cpf' => $request->input('cpf'),
                'temporary_housing' => $request->input('temporary_housing'),
                'about_me' => $request->input('about_me'),
            ]);
        } elseif ($user->user_type === 'ong') {
            $user->ong->update([
                'ong_name' => $request->input('ong_name'),
                'phone' => $request->input('phone'),
                'responsible_name' => $request->input('responsible_name'),
                'responsible_cpf' => $request->input('responsible_cpf'),
                'cnpj' => $request->input('cnpj'),
                'about_ong' => $request->input('about_ong'),
            ]);
        }

        // Handle social links update
        if ($request->has('social_links')) {
            foreach ($request->input('social_links') as $id => $url) {
                if ($url) {
                    $socialNetwork = SocialNetwork::find($id);
                    if ($socialNetwork && $socialNetwork->user_id == $user->id) {
                        $socialNetwork->update(['profile_url' => $url]);
                    }
                }
            }
        }

        // Add new social links
        if ($request->has('new_social_links')) {
            foreach ($request->input('new_social_links') as $url) {
                if ($url) {
                    SocialNetwork::create([
                        'user_id' => $user->id,
                        'profile_url' => $url,
                        'platform_name' => $this->getPlatformName($url),
                    ]);
                }
            }
        }

        // Remove deleted social links
        if ($request->has('deleted_social_links')) {
            SocialNetwork::whereIn('id', $request->input('deleted_social_links'))
                ->where('user_id', $user->id)
                ->delete();
        }

        return redirect()->route('user.public-profile', ['id' => Auth::id()])->with('success', 'Perfil atualizado com sucesso!');
    }

    private function getPlatformName($url)
    {
        if (str_contains($url, 'facebook.com')) {
            return 'Facebook';
        } elseif (str_contains($url, 'twitter.com')) {
            return 'Twitter';
        } elseif (str_contains($url, 'instagram.com')) {
            return 'Instagram';
        } elseif (str_contains($url, 'linkedin.com')) {
            return 'LinkedIn';
        } else {
            return 'Outros';
        }
    }
}
