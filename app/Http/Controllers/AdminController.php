<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.customers', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'fullname' => $request->fullname,
            'email'    => $request->email,
            'password'=> Hash::make($request->password),
            'role'     => $request->role ?? 'User',
            'status'   => $request->status ?? 'Active',
        ]);

        return redirect()->route('admin.customers')->with('success', 'User added successfully!');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'fullname' => $request->fullname,
            'email'    => $request->email,
            'role'     => $request->role,
            'status'   => $request->status,
        ]);

        return redirect()->route('admin.customers')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.customers')->with('success', 'User deleted successfully!');
    }
}