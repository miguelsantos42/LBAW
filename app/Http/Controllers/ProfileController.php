<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pages.profile');
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => [
        'required',
        'max:255',
        Rule::unique('users')->ignore($user->id), // Use the rule here

    ],
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('users')->ignore($user->id), // Use the rule here
        ],
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();

    // Redirect back to the profile page
    return redirect()->route('profile.index'); // Make sure you have a route named 'profile.index'
}

}