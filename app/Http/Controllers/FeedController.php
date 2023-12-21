<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\User;

class FeedController extends Controller
{

     public function index(Request $request)
     {
         $userId = auth()->id();
         $orderType = $request->get('order', 'random');
     
         if ($orderType == 'top') {
             $questions = Question::with('user', 'tags')
                                 ->where('isdeleted', false)
                                 ->orderBy('votecount', 'desc')
                                 ->get();
         } elseif ($orderType == 'recent') {
             $questions = Question::with('user', 'tags')
                                 ->where('isdeleted', false)
                                 ->orderBy('date', 'desc')
                                 ->get();
         } elseif ($orderType == 'myquestions') {
             $questions = Question::with('user', 'tags')
                                 ->where('isdeleted', false)
                                 ->where('usersid', $userId)
                                 ->get();
         } elseif ($orderType == 'myanswers') {
             $questions = Question::with('user', 'tags')->whereHas('comments', function ($query) use ($userId) {
                 $query->where('usersid', $userId);
             })->where('isdeleted', false)
               ->get();
         } elseif($orderType == 'followedquestions') {
            $questions = Question::with('user', 'tags')->whereHas('follows', function ($query) use ($userId) {
                $query->where('usersid', $userId);
            })->where('isdeleted', false)
              ->get();

        } else { // Default to random
             $questions = Question::with('user', 'tags')
                                 ->where('isdeleted', false)
                                 ->inRandomOrder()
                                 ->get();
         }
     
         return view('pages.feed', compact('questions'));
     }
     

    public function show($id)
    {
        $question = Question::with(['comments' => function ($query) {
            $query->where('isDeleted', false);
        }])->findOrFail($id);

        //show the tag that is associated with the question
        $tags = $question->tags()->get();



        return view('question.show', compact('question'));
    }

}
