<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
        // Define the polymorphic relationship with comments
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
