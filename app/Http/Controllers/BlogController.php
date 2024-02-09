<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogFilterRequest;
use App\Http\Requests\FormPostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BlogController extends Controller
{

    public function create()
    {
        $post = new Post();
        return view('blog.create',[
            'post' => $post
        ]);
    }

    public function store(FormPostRequest $request)
    {
        $post = Post::create($request->validated());
        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', "L'article a bien été sauvegardé");
    }

    public function edit(Post $post){
        return view('blog.edit', [
            'post' => $post
        ]);
    }

    public function update(Post $post, FormPostRequest $request){
        $post->update($request->validated());
        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', "L'article a bien été modifié");
    }

    public function index(BlogFilterRequest $request): View
    {
        $category = Category::find(1);
        $post = Post::find(7);
        $post->category()->associate($category);
        $post->save();
        return view('blog.index', [
            'posts' => Post::paginate(1)
        ]);
    }

    public function show(string $slug, Post $post): RedirectResponse | View
    {
        if($post->slug !== $slug){
            return to_route('blog.show', ["slug" => $post->slug, "post" => $post->id]);
        }
        return view('blog.show', [
            'post' => $post
        ]);
    }
}
