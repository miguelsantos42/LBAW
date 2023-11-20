<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question; // Assuming you have a Question model

class FeedController extends Controller
{
    /**
     * Display a listing of the questions.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $userId = auth()->id();
        $orderType = $request->get('order', 'random'); // 'random' is the default

        if ($orderType == 'top') {
            $questions = Question::where('isdeleted', false)
                                ->orderBy('votecount', 'desc')
                                ->get();
        } elseif ($orderType == 'recent') { // This should be an 'else if'
            $questions = Question::where('isdeleted', false)
                                ->orderBy('date', 'desc')
                                ->get();
        }elseif ($orderType == 'myquestions') {
            $questions = Question::where('isdeleted', false)
                                 ->where('usersid', $userId)
                                 ->get();
        }elseif ($orderType == 'myanswers') {
            $questions = Question::whereHas('comments', function ($query) use ($userId) {
                $query->where('usersid', $userId); // Make sure the column name matches the schema
            })->where('isdeleted', false)
              ->get();
        }
                                
        else { // Default to random
            $questions = Question::where('isdeleted', false)
                                ->inRandomOrder()
                                ->get();
        }

        return view('pages.feed', compact('questions'));
    }




    /**
     * Display the specified question and its answers.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the question by ID and load its comments (answers)
        $question = Question::with(['comments' => function ($query) {
            $query->where('isDeleted', false);
        }])->findOrFail($id);

        // Return the view with the question and comments data
        return view('question.show', compact('question'));
    }

}
