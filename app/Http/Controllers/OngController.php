<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ong;

class OngController extends Controller
{


    public function index(Request $request)
    {
        $query = Ong::query();

        // Excluir ONGs que estão como admin
        $query->whereHas('user', function ($q) {
            $q->where('user_type', '!=', 'admin');
        });

        // Filtrar por nome da ONG, se fornecido
        if ($request->filled('ong_name')) {
            $query->where('ong_name', 'like', '%' . $request->ong_name . '%');
        }

        // Filtrar por cidade, se fornecido
        if ($request->filled('city')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('city', 'like', '%' . $request->city . '%');
            });
        }

        $ongs = $query->paginate(9);

        return view('ong.all-ongs', compact('ongs'));
    }

}
