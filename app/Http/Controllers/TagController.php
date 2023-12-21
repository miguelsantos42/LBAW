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

    }

    public function create()
    {
        return view('tags.create');

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tagname' => 'required|unique:tags|max:255',
        ]);
    
        $tag = Tag::create($validatedData);

        return redirect()->route('pages.tags')->with('success', 'Tag created successfully');
    }
    
    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validatedData = $request->validate([ 'tagname' => 'required|unique:tags,tagname,' . $tag->id,]);

        $tag->update($validatedData);

        return redirect()->route('tags.index')->with('success', 'Tag updated sucessfully');
    }



    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Tag deleted successfully');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search'); 
        $tags = Tag::when($searchTerm, function ($query, $searchTerm){
            return $query->where('tagname','LIKE', "%{$searchTerm}%");
        })->get();

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
    

 
}
