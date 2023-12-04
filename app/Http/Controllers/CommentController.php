<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'questionid' => 'required|exists:questions,id',
        ]);

        $comment = new Comment;
        $comment->content = $request->content;
        $comment->usersid = Auth::id();
        $comment->questionid = $request->questionid;  // This should match your form input name
        $comment->save();

        return back()->with('message', 'Answer submitted successfully!');
    }

}
