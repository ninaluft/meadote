<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use HTMLPurifier;
use HTMLPurifier_Config;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Pega os parâmetros de busca e ordenação
        $search = $request->input('search');
        $sort = $request->input('sort', 'desc'); // O valor padrão será 'desc' (Mais Novo)

        // Consulta base de posts
        $query = Post::query();

        // Se a busca por título existir, filtra pelos títulos que contenham a palavra
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Aplica a ordenação (mais novo ou mais antigo)
        $query->orderBy('created_at', $sort);

        // Paginação dos resultados
        $posts = $query->paginate(9); // Mostra 9 posts por página

        // Retorna a view com os posts filtrados e ordenados
        return view('posts.index', compact('posts'));
    }

    // Mostrar o formulário de criação de post
    public function create()
    {
        return view('admin.posts.create');
    }

    // Armazenar o post no banco de dados
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:4000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Configurar o HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        // Sanitizar o conteúdo do post
        $sanitizedContent = $purifier->purify($validated['content']);

        // Criar um novo post
        $post = new Post();
        $post->title = $validated['title'];
        $post->content = $sanitizedContent;
        $post->user_id = auth()->id(); // Associar o post ao usuário logado

        // Armazenar a imagem, se houver
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $post->image_path = $path;
        }

        // Salvar o post no banco de dados
        $post->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Post criado com sucesso.');
    }

    // Mostrar o formulário de edição de post
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    // Atualizar o post no banco de dados
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:4000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Configurar o HTMLPurifier para sanitizar o conteúdo
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $sanitizedContent = $purifier->purify($validated['content']);

        // Atualizar os dados do post
        $post->title = $validated['title'];
        $post->content = $sanitizedContent;

        // Armazenar a nova imagem, se houver
        if ($request->hasFile('image')) {
            // Excluir a imagem antiga, se existir
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }

            // Armazenar a nova imagem
            $path = $request->file('image')->store('posts', 'public');
            $post->image_path = $path;
        }

        // Salvar as atualizações
        $post->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Post atualizado com sucesso.');
    }

    // Excluir o post
    public function destroy(Post $post)
    {
        // Excluir a imagem associada ao post, se existir
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        // Excluir o post
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post excluído com sucesso.');
    }

    // Mostrar um post específico
    public function show(Post $post)
    {
        // Obter o post anterior e o próximo
        $previousPost = Post::where('id', '<', $post->id)->orderBy('id', 'desc')->first();
        $nextPost = Post::where('id', '>', $post->id)->orderBy('id', 'asc')->first();

        return view('posts.show', compact('post', 'previousPost', 'nextPost'));
    }
}
