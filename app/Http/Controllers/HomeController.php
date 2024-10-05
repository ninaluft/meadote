<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->take(3)->get(); // Busca os últimos 3 posts
        return view('welcome', compact('posts')); // Passa os posts para a view
    }
}
