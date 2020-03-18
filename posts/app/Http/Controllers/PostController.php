<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    
    public function index()
    {
        $post = Post::all();
        return $post;
    }

    public function get(Request $request)
    {
        $posts = Post::orderBy('created_at', 'asc')->get();
        return response()->json($posts);
    }
    public function show(Request $request)
    {
        $post = Post::findOrFail($request->id);
        return $post;
    }
    public function store(Request $request)
    {
        $post = new Post();
        $post->author = $request->author;
        $post->title = $request->title;
        $post->content = $request->content;

        $tapostsk->save();
    }
    public function update(Request $request)
    {
        $post = Post::findOrFail($request->id);

        $post->author = $request->author;
        $post->title = $request->title;
        $post->content = $request->content;

        $post->save();

        return $post;
        //Esta función actualizará la tarea que hayamos seleccionado
       
    }
    public function destroy($id)
    {
        $post=Post::destroy($id);

        return $post;
    }
}
