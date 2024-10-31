<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;

use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment) {
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id) {
        // Validate the reqiest data
        $request->validate([
            'comment' => 'required|max:150'
        ]);

        $this->comment->user_id = Auth::user()->id; // Who created the comment?
        $this->comment->post_id = $post_id; // What post was commented on?
        $this->comment->body = $request->comment; // What is the comment?

        # save the comment in the db
        $this->comment->save();

        return redirect()->back();
    }

    public function destroy($id) {
        $this->comment->destroy($id);

        return redirect()->back();
    }
}
