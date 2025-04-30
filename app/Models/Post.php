<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


class Post extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'title',    
        'content',   
        'user_id',
        'photo'
    ];

    public function comments()
    {
            return $this->morphMany(\App\Models\Comment::class, 'commentable');
        
    }

    // Define the relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

}
