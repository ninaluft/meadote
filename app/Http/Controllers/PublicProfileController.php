<?php

namespace App\Http\Controllers;

use App\Models\Ong;
use App\Models\User;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    /**
     * Display the public profile of the user.
     */
    public function show($id)
    {
        // Buscar o usuário cujo perfil será exibido
        $user = User::findOrFail($id);

        // Inicializa a variável $profileData
        $profileData = null;

        // Verifique o tipo de perfil (ONG ou Tutor)
        if ($user->user_type === 'ong') {
            // Se for ONG, buscar os dados da ONG relacionados ao usuário
            $profileData = Ong::where('user_id', $user->id)->firstOrFail();
        } elseif ($user->user_type === 'tutor') {
            // Se for tutor, buscar os dados do tutor
            $profileData = $user->tutor;  // Usando o relacionamento tutor
        }

        return view('user.public-profile', compact('user', 'profileData'));
    }


}
