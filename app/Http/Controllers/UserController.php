<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Admin;
use App\Models\Photo;


class UserController extends Controller
{
    
    public function showLinkRequestForm()
    {
        return view('pages.send-mail');
    }

    public function showUpdatePassForm()
    {
        return view('pages.recover_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:250',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::where('email', '=', $request->input('email'))->first();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('home')
            ->withSuccess('You have successfully changed your password!');
    }

}
