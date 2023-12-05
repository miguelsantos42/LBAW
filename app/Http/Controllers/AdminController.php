<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch all users from the User model
        $users = User::all();

        // Pass the $users data to the 'pages.admin' view
        return view('pages.admin', ['users' => $users]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->input('newName');
        $user->role = $request->input('newRole');
        $user->save();

        return redirect()->route('admin')->with('success', 'User updated successfully');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        if(!empty($searchTerm)) {
            $users = User::query()
                ->where('name','LIKE',"%{$searchTerm}%")
                ->orWhere("email","LIKE","%{$searchTerm}%")
                ->orWhere("role","LIKE","%{$searchTerm}%")
                ->get();
        } else {
            $users = User::all();
        }
        return view('pages.admin', compact('users'));
    }

    //// Delete an user (ONLY) -> Do it by an Admin
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin')->with('success','User deleted sucessfully');
    }

}