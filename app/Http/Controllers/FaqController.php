<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function show()
    {
        $faq = Faq::first(); // Pega o primeiro registro (só temos um)
        return view('faqs.show', compact('faq'));
    }

    // Método para exibir a página de edição
    public function edit()
    {
        $faq = Faq::first(); // Pega o primeiro registro (só temos um)
        return view('admin.faq_edit', compact('faq'));
    }

    // Método para atualizar o conteúdo das FAQs
    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $faq = Faq::first(); // Pega o primeiro registro
        if (!$faq) {
            $faq = new Faq();
        }

        $faq->content = $request->content;
        $faq->save();

        return redirect()->route('faqs.edit')->with('success', 'FAQ atualizada com sucesso!');
    }
}
