<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit()
    {
        return view('staff.users.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'new_password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }
        $user->save();

        return redirect()->back()->with('success', 'Profile updated.');
    }
}
