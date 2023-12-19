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
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'current_password' => [ // Add validation for the current password
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                },
            ],
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'different:current_password', // Add this rule to ensure the new password is different
            ],
        ]);
    
        // Update the user's name and email
        $user->name = $request->name;
        $user->email = $request->email;
    
        // Update the password only if the current password is correct and new password is different
        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();
    
        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
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