<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin IdeHelperPost
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'image'
    ];

    public function category()
    {
        #associe le Modèle Post au Modèle Category
        return $this->belongsTo(Category::class);
    }

    public function tags () 
    {
        return $this->belongsToMany(Tag::class); 
    }

    public function imageUrl ()
    {
        return Storage::disk('public')->url($this->image);
    }
}
