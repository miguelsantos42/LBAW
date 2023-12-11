<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Tag;

class QuestionController extends Controller
{

    public function create()
    {
        $tags = Tag::all(); 
        return view('pages.home')->with('tags', $tags);
        //return view('pages.home', compact('tags'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

       // dd($request->tags);  //tags

        $question = new Question;
        $question->title = $validatedData['title'];
        $question->content = $validatedData['content'];
        $question->usersid = auth()->id(); // Assuming you have user authentication in place 
        $question->save();

        return back()->with('success', 'Your question has been posted.');
        //return view('pages.home', compact('tags'))->with('success', 'Your question has been posted.');
        //return redirect()->back()->with('success', 'Your question has been posted.')->with('tags', $tags);
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


}