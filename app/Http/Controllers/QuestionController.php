<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question; // Import your Question model
use App\Models\VoteQuestion; // Import your VoteQuestion model

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
        $question->usersId = auth()->id(); // Assuming you have user authentication in place
        $question->save();
        return back()->with('success', 'Your question has been posted.');
    }

    public function upvoteQuestion(Request $request, $questionId){
        // Check if the user has already voted on this question
        $existingVote = VoteQuestion::where('usersId', auth()->id())
                                    ->where('questionId', $questionId)
                                    ->first();
    
        $question = Question::findOrFail($questionId);
    
        if ($existingVote) {
            // If they have already upvoted, remove the vote (toggle off)
            if ($existingVote->updown === true) {
                $question->voteCount -= 1;
                $existingVote->delete();
            // If they have downvoted before, change it to an upvote
            } else {
                $question->voteCount += 2; // One to cancel the downvote and one to add the upvote
                $existingVote->updown = true;
                $existingVote->save();
            }
        } else {
            // If they haven't voted before, add a new upvote
            $question->voteCount += 1;
            VoteQuestion::create([
                'updown' => true,
                'usersId' => auth()->id(),
                'questionId' => $questionId
            ]);
        }
    
        $question->save();
        return response()->json(['voteCount' => $question->voteCount]);
    }
    
    public function downvoteQuestion(Request $request, $questionId){
        // Check if the user has already voted on this question
        $existingVote = VoteQuestion::where('usersId', auth()->id())
                                    ->where('questionId', $questionId)
                                    ->first();
    
        $question = Question::findOrFail($questionId);
    
        if ($existingVote) {
            // If they have already downvoted, remove the vote (toggle off)
            if ($existingVote->updown === false) {
                $question->voteCount += 1;
                $existingVote->delete();
            // If they have upvoted before, change it to a downvote
            } else {
                $question->voteCount -= 2; // One to cancel the upvote and one to add the downvote
                $existingVote->updown = false;
                $existingVote->save();
            }
        } else {
            // If they haven't voted before, add a new downvote
            $question->voteCount -= 1;
            VoteQuestion::create([
                'updown' => false,
                'usersId' => auth()->id(),
                'questionId' => $questionId
            ]);
        }
    
        $question->save();
        return response()->json(['voteCount' => $question->voteCount]);
    }
    

}
