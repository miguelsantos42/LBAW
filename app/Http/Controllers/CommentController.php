<?php

namespace App\Http\Controllers;
use App\Models\VoteQuestion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Comment;
use App\Models\Question;
use App\Models\Notification;
use App\Models\CommentNotification;

use App\Models\VoteNotification;

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

        // Retrieve associated models with 'usersid' attribute
        $question = Question::with('user')->findOrFail($comment->questionid);
        $parentComment = ($comment->parent_id) ? Comment::with('user')->findOrFail($comment->parent_id) : null;

        // Checks if there is a usersid in parentComment if not check for usersid in question. If it cant find both set notifusersid to null
        $notifusersid = $parentComment ? $parentComment->user->id : ($question->user->id ?? null);

        if ($notifusersid !== null) {
            // Create a notification record
            $notification = new Notification([
                'content' => $comment->content,
                'usersid' => $notifusersid,
                'questionid' => $comment->questionid
            ]);

            // Save the notification
            $notification->save();

            // Create a commentNotification record
            $commentNotification = new CommentNotification([
                'notificationid' => $notification->id,
                'commentid' => $comment->id
            ]);

            // Save the commentNotification
            $commentNotification->save();
        }

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

                $comment->save();
            } else {
                // Change downvote to upvote
                $comment->votecount += 2;

                DB::table('votecomments')
                  ->where('usersid', $usersid)
                  ->where('commentid', $commentid)
                  ->update(['updown' => true]);

                $comment->save();
    
                // Create a voteNotification record
                $voteNotification = new VoteNotification([
                    'updown' => TRUE,
                    'usersid' => $comment->usersid,
                    'commentid' => $commentid,
                    'questionid' => NULL,
                    'voterid' => $usersid,
                ]);
        
                // Save the voteNotification
                $voteNotification->save();
            }
        } else {
            // First-time vote, add upvote
            $comment->votecount += 1;

            DB::table('votecomments')->insert([
                'updown' => true, 
                'usersid' => $usersid, 
                'commentid' => $commentid
            ]);

            $comment->save();
            // Create a voteNotification record
            $voteNotification = new VoteNotification([
                'updown' => TRUE,
                'usersid' => $comment->usersid,
                'commentid' => $commentid,
                'questionid' => NULL,
                'voterid' => $usersid,
            ]);
    
            // Save the voteNotification
            $voteNotification->save();
        }
    
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

                $comment->save();
            } else {
                // Change upvote to downvote
                $comment->votecount -= 2;

                DB::table('votecomments')
                ->where('usersid', $usersid)
                ->where('commentid', $commentid)
                ->update(['updown' => false]);
                
                $comment->save();
                // Create a voteNotification record
                $voteNotification = new VoteNotification([
                    'updown' => FALSE,
                    'usersid' => $comment->usersid,
                    'commentid' => $commentid,
                    'questionid' => NULL,
                    'voterid' => $usersid,
                ]);
    
                // Save the voteNotification
                $voteNotification->save();
            }
        } else {
            // First-time vote, add downvote
            $comment->votecount -= 1;

            DB::table('votecomments')->insert([
                'updown' => false, 
                'usersid' => $usersid, 
                'commentid' => $commentid
            ]);

            $comment->save();
            // Create a voteNotification record
            $voteNotification = new VoteNotification([
                'updown' => FALSE,
                'usersid' => $comment->usersid,
                'commentid' => $commentid,
                'questionid' => NULL,
                'voterid' => $usersid,
            ]);

            // Save the voteNotification
            $voteNotification->save();
        }

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