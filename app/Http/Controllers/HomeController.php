<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag; // Make sure to use your Tag model

class HomeController extends Controller
{
    public function index()
    {
        $tags = Tag::all(); // Get all tags
        return view('pages.home', compact('tags'));
    }
}
