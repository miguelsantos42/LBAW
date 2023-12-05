<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 0, // Ensure this is a valid role ID in your `role` table
        ]);
        
        //Auth::login($user); // Log the user in
        //$request->session()->regenerate(); // Regenerate the session

        // Redirect to a route that you know exists. For example, to a 'dashboard' or 'home'.
        return redirect()->route('home') // Replace 'home' with the name of the route you wish to redirect to.
            ->withSuccess('You have successfully registered & logged in!');
    }

}
