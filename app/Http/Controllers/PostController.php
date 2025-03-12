<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('images')->paginate(12);

        return view('front.all-activities', compact('posts'));
    }
}
