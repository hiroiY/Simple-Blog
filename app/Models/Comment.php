<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // A comment belongs to a post
    # To get all the posts where the comment belongs to
    public function post() {
        return $this->belongsTo(Post::class);
    }

    # A comment belongs to a user
    # To get the owner of the comment.
    public function user() {
        return $this->belongsTo(User::class);
    }
}
