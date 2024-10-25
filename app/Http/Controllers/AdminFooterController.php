<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;


class AdminFooterController extends Controller
{
    public function edit()
    {
        // Verifica se há algum registro de rodapé no banco de dados
        $footer = Footer::first();

        // Caso não exista, define uma string vazia como conteúdo
        if (!$footer) {
            $footerContent = ''; // conteúdo vazio se não existir
        } else {
            $footerContent = $footer->content;
        }

        return view('admin.content-update.footer', compact('footerContent'));
    }




    public function update(Request $request)
    {
        $request->validate(['content' => 'required|string']);
        $footer = Footer::first();
        if ($footer) {
            $footer->update(['content' => $request->content]);
        } else {
            Footer::create(['content' => $request->content]);
        }
        return redirect()->route('admin.dashboard')->with('success', 'Rodapé atualizado com sucesso!');
    }
}
