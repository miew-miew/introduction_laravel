<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPost
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content'
    ];

    public function category()
    {
        #associe le Modèle Post au Modèle Category
        return $this->belongsTo(Category::class);
    }
}
