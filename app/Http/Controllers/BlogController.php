<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormPostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BlogController extends Controller
{

    public function create()
    {
        $post = new Post();
        return view('blog.create',[
            'post' => $post,
            'categories' =>Category::select('id', 'name')->get(),
            'tags' =>Tag::select('id', 'name')->get()
        ]);
    }

    public function store(FormPostRequest $request)
    {
        $post = Post::create($request->validated());
        $post->tags()->sync($request->validated('tags'));
        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', "L'article a bien été sauvegardé");
    }

    public function edit(Post $post){
        return view('blog.edit', [
            'post' => $post,
            'categories' =>Category::select('id', 'name')->get(),
            'tags' =>Tag::select('id', 'name')->get()
        ]);
    }

    public function update(Post $post, FormPostRequest $request){
        $post->update($request->validated());
        $post->tags()->sync($request->validated('tags'));
        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', "L'article a bien été modifié");
    }

    public function index(): View
    {
        return view('blog.index', [
            'posts' => Post::with('tags', 'category')->paginate(10)
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
