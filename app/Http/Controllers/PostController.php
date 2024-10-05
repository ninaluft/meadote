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
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(5); // Busca os posts ordenados pela data de criação
        return view('posts.index', compact('posts')); // Retorna a view com a variável $posts
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

        $post = new Post();
        $post->title = $validated['title'];
        $post->content = $sanitizedContent;
        $post->user_id = auth()->id(); // Usando user_id

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $post->image_path = $path;
        }

        $post->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Post criado com sucesso.');
    }



    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'content']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('posts.show', $post->id)->with('success', 'Post atualizado com sucesso.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post excluído com sucesso.');
    }

    public function show(Post $post)
    {
        $previousPost = Post::where('id', '<', $post->id)->orderBy('id', 'desc')->first();
        $nextPost = Post::where('id', '>', $post->id)->orderBy('id', 'asc')->first();

        return view('posts.show', compact('post', 'previousPost', 'nextPost'));
    }

}
