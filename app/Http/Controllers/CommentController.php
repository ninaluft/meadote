<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Armazena o novo comentário
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|min:3|max:1000',
        ]);

        Comment::create([
            'content' => $request->input('content'),
            'post_id' => $post->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('posts.show', $post->id)->with('success', 'Comentário adicionado com sucesso!');
    }

    public function destroy(Comment $comment)
    {
        // Verifica se o usuário logado é o autor do comentário ou um admin
        if (auth()->user()->id === $comment->user_id || auth()->user()->user_type === 'admin') {
            $comment->delete();
            return redirect()->back()->with('success', 'Comentário excluído com sucesso!');
        }

        return redirect()->back()->with('error', 'Você não tem permissão para excluir este comentário.');
    }
}
