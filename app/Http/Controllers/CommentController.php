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

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Check if the authenticated user can delete this comment
        if (auth()->id() === $comment->usersid) {
            $comment->delete();
            return redirect()->route('feed.index')->with('success', 'Comment deleted successfully.');
        } else {
            // Optionally, you might want to abort with a 403 if the user is not authorized
            // abort(403, 'Unauthorized action.');
            return redirect()->route('feed.index')->with('error', 'You cannot delete this comment.');
        }
    }
}