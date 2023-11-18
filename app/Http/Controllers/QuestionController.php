<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question; // Import your Question model

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
}
