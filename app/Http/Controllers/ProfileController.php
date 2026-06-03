<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function showProfile(){
        return view('/admin/profile');
    }

    public function editPicture(Request $request){
        $user = User::find(session('user')->id);

        if($request->hasFile('profile_pic')){
            $file = $request->file('profile_pic');
            $filename = time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'),$filename);

            $user->update([
                'profile_picture'=>$filename
            ]);
        }
        
        session(['user' => $user->fresh()]);
        return back()->with('success', 'Profile Updated');
    }

    public function updateProfile(Request $request)
{
    $user = User::find(session('user')->id);

    $request->validate([
        'fullname' => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    $data = [
        'fullname' => $request->fullname,
        'email'    => $request->email,
    ];

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    session(['user' => $user->fresh()]);
    return back()->with('edit_success', 'Profile updated successfully.');
}

}
