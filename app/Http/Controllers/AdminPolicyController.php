<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policy; // Ajuste para o seu modelo

class AdminPolicyController extends Controller
{
    /**
     * Exibe a Política de Privacidade publicamente.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $policy = Policy::orderBy('created_at', 'desc')->first(); // Obtém o último registro da Política
        $policyContent = $policy ? $policy->content : ''; // Caso não haja conteúdo, exibe vazio

        return view('policy', compact('policyContent')); // Passa a variável para a view
    }


    /**
     * Exibe a página de edição da Política de Privacidade (somente para admins).
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        // Recupera o conteúdo da Política de Privacidade mais recente
        $policy = Policy::latest()->first(); // Obtém o último registro da Política
        $policyContent = $policy ? $policy->content : ''; // Caso não haja conteúdo, exibe vazio
        $title = $policy ? $policy->title : ''; // Caso não haja conteúdo, exibe vazio

        return view('admin.content-update.policy', compact('policyContent', 'title')); // Passa a variável para a view
    }

    /**
     * Armazena o conteúdo da Política de Privacidade no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validação do conteúdo
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        // Cria um novo registro de Política de Privacidade
        Policy::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // Redireciona de volta com uma mensagem de sucesso
        return redirect()->route('admin.policy.edit')->with('success', 'Novo registro de Política de Privacidade criado com sucesso!');
    }
}
