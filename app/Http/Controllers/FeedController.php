<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question; // Assuming you have a Question model
use App\Models\User;

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
     
         // Add with('user') to each query to eager load the user relationship
         if ($orderType == 'top') {
             $questions = Question::with('user')
                                 ->where('isdeleted', false)
                                 ->orderBy('votecount', 'desc')
                                 ->get();
         } elseif ($orderType == 'recent') {
             $questions = Question::with('user')
                                 ->where('isdeleted', false)
                                 ->orderBy('date', 'desc')
                                 ->get();
         } elseif ($orderType == 'myquestions') {
             $questions = Question::with('user')
                                 ->where('isdeleted', false)
                                 ->where('usersid', $userId)
                                 ->get();
         } elseif ($orderType == 'myanswers') {
             $questions = Question::with('user')->whereHas('comments', function ($query) use ($userId) {
                 $query->where('usersid', $userId);
             })->where('isdeleted', false)
               ->get();
         } else { // Default to random
             $questions = Question::with('user')
                                 ->where('isdeleted', false)
                                 ->inRandomOrder()
                                 ->get();
         }
     
         return view('pages.feed', compact('questions'));
     }
     

    public function users()
    {
        // Fetch all users from the User model
        $users = User::all();

        // Pass the $users data to the 'pages.admin' view
        return view('pages.feed', ['users' => $users]);
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
