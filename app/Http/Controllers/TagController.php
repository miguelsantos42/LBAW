<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tagName' => 'required|unique:tags|max:255',
            //'description' => 'nullable|max:255',
        ]);

        $tag = Tag::create($validatedData);
        return redirect()->route('tags.index')->with('success', 'Tag created successfully');
    }

    public function show(Tag $tag)
    {
        return view('tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }


    public function update(Request $request, Tag $tag)
    {
        $validatedData = $request->validate([
            'tagName' => 'required|unique:tags|max:255',
            //'description' => 'nullable|max:255',
        ]);

        $tag->update($validatedData);
        return redirect()->route('tags.index')->with('success', 'Tag updated successfully');
    }

 
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully');
    }
}
