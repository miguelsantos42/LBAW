<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    
    return redirect()->route('profile.index');
}

    public function delete()
    {
        $user = Auth::user();
        $user->name = "Anonymous";
        $user->email = "anonymous" . $user->id . "@example.com";
        $user->password = Hash::make(Str::random(40)); 
        $user->save();
        Auth::logout();
        return redirect()->route('home');
    }

}