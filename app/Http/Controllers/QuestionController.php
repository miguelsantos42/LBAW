<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Tag;
use App\Models\VoteQuestion;
use App\Models\VoteNotification;


class QuestionController extends Controller
{

    public function create()
    {
        $tags = Tag::all();
        return view('pages.home', compact('tags'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $question = new Question;
        $question->title = $validatedData['title'];
        $question->content = $validatedData['content'];
        $question->usersid = auth()->id(); 
        $question->save();

        if($request->has('tags')) {
            $question->tags()->attach($request->tags);
        }


        return back()->with('success', 'Your question has been posted.');

    }


    public function destroy($id)
    {
        
        $question = Question::where('id', $id)->firstOrFail();
        $question->delete();
        return response()->json(['success' => 'Question deleted successfully']);

    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);

        $tags = Tag::all(); 

        return view('pages.editquestion', compact('question', 'tags'));
    }


    public function update(Request $request, Question $question)
    {
        $question->title = $request->title;
        $question->content = $request->content;
        $question->edited = true;
        $question->tags()->sync($request->tags);
        $question->save();
        return redirect()->route('questions.show', $question->id);
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
        $userid = Auth::id();
        $question = Question::findOrFail($questionid);
        $existingVote = DB::table('votequestions')
                            ->where('usersid', $userid)
                            ->where('questionid', $questionid)
                            ->first();
    
        if ($existingVote) {
            if ($existingVote->updown) {
                // Already upvoted, so remove the vote
                $question->votecount--;
                DB::table('votequestions')
                    ->where('usersid', $userid)
                    ->where('questionid', $questionid)
                    ->delete();
            } else {
                // Change downvote to upvote
                $question->votecount += 2;
                DB::table('votequestions')
                    ->where('usersid', $userid)
                    ->where('questionid', $questionid)
                    ->update(['updown' => true]);
            }
        } else {
            // First-time vote, add upvote
            $question->votecount++;
            DB::table('votequestions')->insert([
                'updown' => true,
                'usersid' => $userid,
                'questionid' => $questionid
            ]);
        }
    
        $question->save();
    
        // Add any necessary logic for notifications here
    
        return response()->json(['votecount' => $question->votecount]);
    }
    
    public function downvoteQuestion(Request $request, $questionid) {
        $userid = Auth::id();
        $question = Question::findOrFail($questionid);
        $existingVote = DB::table('votequestions')
                            ->where('usersid', $userid)
                            ->where('questionid', $questionid)
                            ->first();
    
        if ($existingVote) {
            if (!$existingVote->updown) {
                // Already downvoted, so remove the vote
                $question->votecount++;
                DB::table('votequestions')
                    ->where('usersid', $userid)
                    ->where('questionid', $questionid)
                    ->delete();
            } else {
                // Change upvote to downvote
                $question->votecount -= 2;
                DB::table('votequestions')
                    ->where('usersid', $userid)
                    ->where('questionid', $questionid)
                    ->update(['updown' => false]);
            }
        } else {
            // First-time vote, add downvote
            $question->votecount--;
            DB::table('votequestions')->insert([
                'updown' => false,
                'usersid' => $userid,
                'questionid' => $questionid
            ]);
        }
    
        $question->save();
    
        // Add any necessary logic for notifications here
    
        return response()->json(['votecount' => $question->votecount]);
    }
    


}