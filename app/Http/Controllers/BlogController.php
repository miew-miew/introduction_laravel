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
        $post = new Post(); // Initialise un nouvel objet Post
        return view('blog.create',[ 
            'post' => $post, // Passe l'objet Post à la vue
            'categories' =>Category::select('id', 'name')->get(), // Récupère les catégories pour la vue
            'tags' =>Tag::select('id', 'name')->get() // Récupère les tags pour la vue
        ]);
    }

    public function store(FormPostRequest $request) 
    {
        $post = Post::create($request->validated()); // Crée un nouvel article avec les données validées du formulaire
        $post->tags()->sync($request->validated('tags')); // Associe les tags à l'article
        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', "L'article a bien été sauvegardé"); // Redirige vers la vue de l'article avec un message de succès
    }

    public function edit(Post $post){ 
        return view('blog.edit', [ 
            'post' => $post, 
            'categories' =>Category::select('id', 'name')->get(), 
            'tags' =>Tag::select('id', 'name')->get() 
        ]);
    }

    public function update(Post $post, FormPostRequest $request){ 
        $post->update($request->validated()); // Met à jour l'article avec les données validées du formulaire
        $post->tags()->sync($request->validated('tags')); // Met à jour les tags associés à l'article
        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', "L'article a bien été modifié"); // Redirige vers la vue de l'article avec un message de succès
    }

    public function index(): View 
    {
        return view('blog.index', [ 
            'posts' => Post::with('tags', 'category')->paginate(10) // Récupère les articles paginés avec leurs tags et catégories associés
        ]);
    }

    public function show(string $slug, Post $post): RedirectResponse | View 
    {
        if($post->slug !== $slug){ // Vérifie si le slug de l'article correspond au slug donné
            return to_route('blog.show', ["slug" => $post->slug, "post" => $post->id]); // Redirige vers l'URL correcte si les slugs ne correspondent pas
        }
        return view('blog.show', [ 
            'post' => $post // Passe l'objet Post à la vue
        ]);
    }
}
