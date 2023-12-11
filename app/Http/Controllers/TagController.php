<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();

        return view('pages.tags ', compact('tags'));
        
        //return view('tags.index ', compact('tags'));

        //return view('pages.tags ', ['tags' => $tags]);
    }

    
    public function create()
    {
       
        return view('tags.create');
        
        //return redirect()->back();
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

    public function search(Request $request)
    {
        $search = $request->input('search'); 
    
        $tags = Tag::where('tagName', 'LIKE', "%$search%")->get();

        return view('tags.index', compact('tags'));
    }

    public function show(Tag $tag)
    {
        return view('tags.show', compact('tag'));
    }

    public function showTag($id){
        $tag = Tag::find($id);
       
        return view('pages.tag', ['tag' => $tag]);
    }
    
    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }


    public function update(Request $request, Tag $tag)
    {
        $validatedData = $request->validate([
            'tagName' => 'required|unique:tags|max:255',
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
