<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Terms; // Ajuste para o seu modelo

class AdminTermsController extends Controller
{
    /**
     * Exibe a página de edição dos Termos de Uso (somente para admins).
     *
     * @return \Illuminate\Http\Response
     */

     public function show()
     {
         // Recupera o conteúdo dos Termos de Uso mais recentes
         $terms = Terms::latest()->first(); // Obtém o último registro de Termos
         $termsContent = $terms ? $terms->content : ''; // Caso não haja conteúdo, exibe vazio


         return view('terms', compact('termsContent')); // Passa a variável para a view
     }


    public function edit()
    {
        // Recupera o conteúdo dos Termos de Uso
        $terms = Terms::latest()->first(); // Obtém o último registro de Termos
        $termsContent = $terms ? $terms->content : ''; // Caso não haja conteúdo, exibe vazio
        $title =  $terms ? $terms->title : '';

        return view('admin.content-update.terms', compact('termsContent', 'title')); // Passa a variável para a view
    }

    /**
     * Armazena o conteúdo dos Termos de Uso no banco de dados.
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

        // Cria um novo registro de Termos de Uso
        Terms::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // Redireciona de volta com uma mensagem de sucesso
        return redirect()->route('admin.terms.edit')->with('success', 'Novo registro de Termos de Uso criado com sucesso!');
    }
}
