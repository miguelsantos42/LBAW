<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

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

        $request->validate([
            'newName' => 'required|string|max:250',
            'newEmail' => 'required|email|max:250|unique:users,email,' . $id,
            'newPassword' => 'nullable|min:8',
            'newRole' => 'required',
        ]);

        $user->name = $request->input('newName');
        $user->email = $request->input('newEmail');
        $user->role = $request->input('newRole');

        if ($request->filled('newPassword')) {
            $user->password = Hash::make($request->input('newPassword'));
        }

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

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin')->with('success','User deleted sucessfully');
    }
}