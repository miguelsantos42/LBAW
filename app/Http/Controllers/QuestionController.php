<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Question;

use App\Models\VoteNotification;


class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $question = new Question;
        $question->title = $validatedData['title'];
        $question->content = $validatedData['content'];
        $question->usersid = auth()->id(); // Assuming you have user authentication in place
        $question->save();
        return back()->with('success', 'Your question has been posted.');
    }

    public function destroy($id)
    {
        
        $question = Question::where('id', $id)->where('usersid', auth()->id())->firstOrFail();
        $question->delete();
        return response()->json(['success' => 'Question deleted successfully']);

    }

    public function update(Request $request, Question $question)
    {
        $question->title = $request->title;
        $question->content = $request->content;
        $question->save();
        return back()->with('message', 'Question updated successfully!');
    }

    public function index()
    {
        $questions = Question::with('comments')->get();

        return view('pages.feed', compact('questions'));
    }

    public function show($id)
    {
        $question = Question::with(['comments' => function ($query) {
            $query->whereNull('parent_id'); 
        }, 'comments.replies', 'comments.user'])->findOrFail($id);

        $nestedComments = true;

        return view('pages.question', compact('question', 'nestedComments'));
    }

    public function upvoteQuestion(Request $request, $questionid) {
        $usersid = Auth::id();
        $question = Question::findOrFail($questionid);
        $existingVote = DB::table('votequestions')
                          ->where('usersid', $usersid)
                          ->where('questionid', $questionid)
                          ->first();
    
    
        if ($existingVote) {
            if ($existingVote->updown === true) {
                // Already upvoted, so remove the vote
                $question->votecount -= 1;
                
                DB::table('votequestions')
                  ->where('usersid', $usersid)
                  ->where('questionid', $questionid)
                  ->delete();

                $question->save();
            } else {
                // Change downvote to upvote
                $question->votecount += 2;

                DB::table('votequestions')
                  ->where('usersid', $usersid)
                  ->where('questionid', $questionid)
                  ->update(['updown' => true]);

                $question->save();
    
                // Create a voteNotification record
                $voteNotification = new VoteNotification([
                    'updown' => TRUE,
                    'usersid' => $question->usersid,
                    'commentid' => NULL,
                    'questionid' => $questionid,
                    'voterid' => $usersid,
                ]);
        
                // Save the voteNotification
                $voteNotification->save();
            }
        } else {
            // First-time vote, add upvote
            $question->votecount += 1;

            DB::table('votequestions')->insert([
                'updown' => true, 
                'usersid' => $usersid, 
                'questionid' => $questionid
            ]);

            $question->save();
            // Create a voteNotification record
            $voteNotification = new VoteNotification([
                'updown' => TRUE,
                'usersid' => $question->usersid,
                'commentid' => NULL,
                'questionid' => $questionid,
                'voterid' => $usersid,
            ]);
    
            // Save the voteNotification
            $voteNotification->save();
        }
    
        return response()->json(['votecount' => $question->votecount]);
    }

    public function downvoteQuestion(Request $request, $questionid) {
        $usersid = Auth::id();
        $question = Question::findOrFail($questionid);
        $existingVote = DB::table('votequestions')
                        ->where('usersid', $usersid)
                        ->where('questionid', $questionid)
                        ->first();

        if ($existingVote) {
            if ($existingVote->updown === false) {
                // Already downvoted, so remove the vote
                $question->votecount += 1;

                DB::table('votequestions')
                ->where('usersid', $usersid)
                ->where('questionid', $questionid)
                ->delete();

                $question->save();
            } else {
                // Change upvote to downvote
                $question->votecount -= 2;

                DB::table('votequestions')
                ->where('usersid', $usersid)
                ->where('questionid', $questionid)
                ->update(['updown' => false]);
                
                $question->save();
                // Create a voteNotification record
                $voteNotification = new VoteNotification([
                    'updown' => FALSE,
                    'usersid' => $question->usersid,
                    'commentid' => NULL,
                    'questionid' => $questionid,
                    'voterid' => $usersid,
                ]);
    
                // Save the voteNotification
                $voteNotification->save();
            }
        } else {
            // First-time vote, add downvote
            $question->votecount -= 1;

            DB::table('votequestions')->insert([
                'updown' => false, 
                'usersid' => $usersid, 
                'questionid' => $questionid
            ]);

            $question->save();
            // Create a voteNotification record
            $voteNotification = new VoteNotification([
                'updown' => FALSE,
                'usersid' => $question->usersid,
                'commentid' => NULL,
                'questionid' => $questionid,
                'voterid' => $usersid,
            ]);

            // Save the voteNotification
            $voteNotification->save();
        }

        return response()->json(['votecount' => $question->votecount]);
    }





}