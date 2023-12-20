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
        $request->validate([ 'tagname' => 'required' ]);

        $tag->update([ 'tagname' => $request->name ]);

        return to_route('tags.index')->with('success', 'Tag updated successfully');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Tag deleted successfully');
    }

    public function search(Request $request)
    {
        $searchtag = $request->input('search'); 
        if(!empty($searchtag)){
            $tags = Tag::query()
            ->where('tagname', 'LIKE', "%{$searchtag}%")
            ->get();
        }else{
            $tags = Tag::all();
        }
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
    
    //-- Follow Tags
    public function follow(Tag $tag) 
    {
        $user = auth()->user();
        $user->followedTags()->attach($tag->id);

        return redirect()->back()->with('success', "followed successfully!");
    }

    public function unfollow(Tag $tag) 
    {
        $user = auth()->user();
        $user->followedTags()->detach($tag->id);

        return redirect()->back()->with('success', "followed successfully!");
    }

}
