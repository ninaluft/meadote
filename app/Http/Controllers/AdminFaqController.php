<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class AdminFaqController extends Controller
{
    /**
     * Exibe as FAQs publicamente.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // Recupera o conteúdo das FAQs
        $faq = Faq::first();
        $faqContent = $faq ? $faq->content : ''; // Caso não haja conteúdo, exibe vazio

        return view('faqs.show', compact('faqContent'));
    }

    /**
     * Exibe a página de edição de FAQs (somente para admins).
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        // Recupera o conteúdo das FAQs
        $faq = Faq::first();
        $faqContent = $faq ? $faq->content : '';

        return view('admin.content-update.faq', compact('faqContent'));
    }

    /**
     * Armazena o conteúdo das FAQs no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validação do conteúdo
        $request->validate([
            'faq_content' => 'required|string',
        ]);

        // Salvar ou atualizar o conteúdo das FAQs
        $faq = Faq::first();
        if ($faq) {
            // Atualiza o conteúdo existente
            $faq->content = $request->faq_content;
            $faq->save();
        } else {
            // Cria um novo registro de FAQ
            Faq::create([
                'content' => $request->faq_content,
            ]);
        }

        // Redireciona de volta com uma mensagem de sucesso
        return redirect()->route('faqs.edit')->with('success', 'FAQs salvas com sucesso!');
    }
}
