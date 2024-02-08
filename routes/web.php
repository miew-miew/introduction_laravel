<?php

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/blog')->name('blog.')->group(function () {
    Route::get('/', function (Request $request) {
        return Post::paginate(25);
    })->name('index');

    Route::get('/{slug}-{id}', function (string $slug, string $id, Request $request) {
        $post = Post::findOrFail($id);
        if($post->slug !== $slug){
            return to_route('blog.show', ["slug" => $post->slug, "id" => $post->id]);
        }
        return $post;
    })->where([
        "id" => '[0-9]+',
        "slug" => '[a-z0-9\-]+'
    ])->name('show');
});