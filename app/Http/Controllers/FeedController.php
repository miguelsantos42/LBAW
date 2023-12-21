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
             $title = 'Top Questions';
         } elseif ($orderType == 'recent') {
             $questions = Question::with('user', 'tags')
                                 ->where('isdeleted', false)
                                 ->orderBy('date', 'desc')
                                 ->get();
            $title = 'Recent Questions';
         } elseif ($orderType == 'myquestions') {
             $questions = Question::with('user', 'tags')
                                 ->where('isdeleted', false)
                                 ->where('usersid', $userId)
                                 ->get();
            $title = 'My Questions';
         } elseif ($orderType == 'myanswers') {
             $questions = Question::with('user', 'tags')->whereHas('comments', function ($query) use ($userId) {
                 $query->where('usersid', $userId);
             })->where('isdeleted', false)
               ->get();
            $title = 'My Answers';
         } elseif($orderType == 'followedquestions') {
            $questions = Question::with('user', 'tags')->whereHas('follows', function ($query) use ($userId) {
                $query->where('usersid', $userId);
            })->where('isdeleted', false)
              ->get();
            $title = 'Followed Questions';

        } else { // Default to random
             $questions = Question::with('user', 'tags')
                                 ->where('isdeleted', false)
                                 ->inRandomOrder()
                                 ->get();
            $title = 'Feed';
         }
     
         return view('pages.feed', compact('questions', 'title'));
     }
     

    public function show($id)
    {
        $question = Question::with(['comments' => function ($query) {
            $query->where('isDeleted', false);
        }])->findOrFail($id);

        $tags = $question->tags()->get();



        return view('question.show', compact('question'));
    }

}
