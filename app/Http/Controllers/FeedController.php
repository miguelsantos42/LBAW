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
    public function index()
    {
        // Fetch all questions that are not marked as deleted
        $questions = Question::where('isDeleted', false)->get();

        // Return the view with the questions data
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
