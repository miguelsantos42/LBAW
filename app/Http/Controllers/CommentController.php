<?php

namespace App\Http\Controllers;
use App\Models\VoteQuestion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Comment;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VoteComment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'questionid' => 'required|exists:questions,id',
            'parent_id' => 'nullable|exists:comments,id', 
        ]);

        $comment = new Comment;
        $comment->content = $request->content;
        $comment->usersid = Auth::id();
        $comment->questionid = $request->questionid;
        $comment->parent_id = $request->parent_id;
        $comment->save();

        return back()->with('message', 'Answer submitted successfully!');
    }

  
    public function upvoteComment(Request $request, $commentid) {
    $usersid = Auth::id();
    $comment = Comment::findOrFail($commentid);
    $existingVote = DB::table('votecomments')
                      ->where('usersid', $usersid)
                      ->where('commentid', $commentid)
                      ->first();

    if ($existingVote) {
        if ($existingVote->updown === true) {
            // Already upvoted, so remove the vote
            $comment->votecount -= 1;
            DB::table('votecomments')
              ->where('usersid', $usersid)
              ->where('commentid', $commentid)
              ->delete();
        } else {
            // Change downvote to upvote
            $comment->votecount += 2;
            DB::table('votecomments')
              ->where('usersid', $usersid)
              ->where('commentid', $commentid)
              ->update(['updown' => true]);
        }
    } else {
        // First-time vote, add upvote
        $comment->votecount += 1;
        DB::table('votecomments')->insert([
            'updown' => true, 
            'usersid' => $usersid, 
            'commentid' => $commentid
        ]);
    }

    $comment->save();
    return response()->json(['votecount' => $comment->votecount]);
}

public function downvoteComment(Request $request, $commentid) {
    $usersid = Auth::id();
    $comment = Comment::findOrFail($commentid);
    $existingVote = DB::table('votecomments')
                      ->where('usersid', $usersid)
                      ->where('commentid', $commentid)
                      ->first();

    if ($existingVote) {
        if ($existingVote->updown === false) {
            // Already downvoted, so remove the vote
            $comment->votecount += 1;
            DB::table('votecomments')
              ->where('usersid', $usersid)
              ->where('commentid', $commentid)
              ->delete();
        } else {
            // Change upvote to downvote
            $comment->votecount -= 2;
            DB::table('votecomments')
              ->where('usersid', $usersid)
              ->where('commentid', $commentid)
              ->update(['updown' => false]);
        }
    } else {
        // First-time vote, add downvote
        $comment->votecount -= 1;
        DB::table('votecomments')->insert([
            'updown' => false, 
            'usersid' => $usersid, 
            'commentid' => $commentid
        ]);
    }

    $comment->save();
    return response()->json(['votecount' => $comment->votecount]);
}

    
    

}