<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
//use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        $comment = new Comment;
        $comment->content = request()->content;
        $comment->article_id = request()->article_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return back();
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        if (Gate::denies('delete-comment', $comment)) {
            return back()->with("info", "Unauthorize");
        }

        $comment->delete();
        return back()->with("info", "A comment is deleted");
    }
}
