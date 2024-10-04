<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use Illuminate\Http\Request;

class TemporaryHousingController extends Controller
{
    /**
     * Display a list of tutors offering temporary housing.
     */
    public function index(Request $request)
    {
        // Verificar se há uma busca por nome ou cidade
        $query = Tutor::where('temporary_housing', true);

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');

            // Relacionamento entre `tutors` e `users` para buscar por cidade ou nome
            $query->where(function($q) use ($searchTerm) {
                $q->where('full_name', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function($q) use ($searchTerm) {
                      $q->where('city', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Paginação dos resultados (10 por página)
        $tutors = $query->paginate(10);

        // Preservar o termo de busca na paginação
        $tutors->appends($request->except('page'));

        return view('temporary-housing.index', compact('tutors'));
    }
}
