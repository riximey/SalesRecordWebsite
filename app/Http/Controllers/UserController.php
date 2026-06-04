<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showUsers(){
        $users = User::all()
        ->where('archived', 0);
        return view('users', compact('users'));
    }

    public function editUser(Request $request){
        $user =  User::where('id', $request->hiddenId);

        $user->update([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Updated successfully!');
    }

    public function archiveUser(Request $request){
        $user =  User::where('id', $request->hiddenId);

        $user->update([
            'archived' => 1
        ]);

        return back()->with('success', 'Archived successfully!');
    }

    public function addUser(Request $request){
        if(User::where("email", $request->email)->where("archived", 0)->exists()){
            return back()->with("error","Email already exist!");
        }

        User::create([
            "fullname"=> $request->fullname,
            "email"=> $request->email,
            "role"=> $request->role,
            "password"=> Hash::make("password")
        ]);

        return back()->with("success","Registered Successfully!");
    }
}
