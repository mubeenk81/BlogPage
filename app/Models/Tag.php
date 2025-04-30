<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name'];

    // public function posts()
    // {
    //     return $this->belongsToMany(Post::class);
    // }

        // A tag can belong to many different models (Post, Comment)
        public function posts(): MorphToMany
        {
            return $this->morphedByMany(Post::class, 'taggable');
        }
        
        public function comments(): MorphToMany
        {
            return $this->morphedByMany(Comment::class, 'taggable');
        }
        
}
