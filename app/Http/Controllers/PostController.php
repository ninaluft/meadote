<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\ImageService;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

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

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Configurar o HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $sanitizedContent = $purifier->purify($validated['content']);

        $post = new Post();
        $post->title = $validated['title'];
        $post->content = $sanitizedContent;
        $post->user_id = auth()->id(); // Associar o post ao usuário logado

        // Armazenar a imagem, se houver, usando o ImageService
        // Armazenar a imagem, se houver, usando o ImageService
        if ($request->hasFile('image')) {
            $imageData = $this->imageService->uploadImage($request->file('image')->getRealPath(), 'posts');

            // Verifica se a imagem foi considerada imprópria
            if (isset($imageData['secure_url']) && isset($imageData['public_id'])) {
                $post->image_path = $imageData['secure_url'];
                $post->image_public_id = $imageData['public_id']; // Guardar o public_id para exclusão futura
            } else {
                return redirect()->back()->with('error', 'A imagem foi detectada como imprópria.');
            }
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Configurar o HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $sanitizedContent = $purifier->purify($validated['content']);

        $post->title = $validated['title'];
        $post->content = $sanitizedContent;


        // Se houver uma nova imagem, fazer o upload e deletar a antiga
        if ($request->hasFile('image')) {
            // Excluir a imagem antiga, se existir
            if ($post->image_public_id) {
                $this->imageService->deleteImage($post->image_public_id);
            }

            // Fazer upload da nova imagem
            $imageData = $this->imageService->uploadImage($request->file('image')->getRealPath(), 'posts');

            // Verifica se a imagem foi considerada imprópria
            if (isset($imageData['secure_url']) && isset($imageData['public_id'])) {
                // Atualiza o caminho e o public_id da nova imagem
                $post->image_path = $imageData['secure_url'];
                $post->image_public_id = $imageData['public_id'];
            } else {
                return redirect()->back()->with('error', 'A imagem foi detectada como imprópria.');
            }
        }




        $post->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Post atualizado com sucesso.');
    }


    public function destroy(Post $post)
    {
        // Excluir a imagem associada, se existir
        if ($post->image_public_id) {
            $this->imageService->deleteImage($post->image_public_id);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post excluído com sucesso.');
    }

    public function show(Post $post)
    {
        // Obter o post anterior e o próximo
        $previousPost = Post::where('id', '<', $post->id)->orderBy('id', 'desc')->first();
        $nextPost = Post::where('id', '>', $post->id)->orderBy('id', 'asc')->first();

        return view('posts.show', compact('post', 'previousPost', 'nextPost'));
    }
}
