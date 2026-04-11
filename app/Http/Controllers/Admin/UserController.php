<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role', 'admin');
        $users = User::where('role', $role)->get();
        return view('admin.users.index', compact('users', 'role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,staff',
        ]);

        // Temporarily create to get ID for count
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('placeholder'),
            'role' => $request->role,
            'is_default_password' => true,
        ]);

        $colNumber = User::where('role', $request->role)->where('id', '<=', $user->id)->count();
        $passwordPlain = substr($request->email, 0, 4) . $colNumber;
        
        $user->update(['password' => Hash::make($passwordPlain)]);

        return redirect()->back()->with('success', 'Pengguna berhasil dibuat. Password: ' . $passwordPlain);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'new_password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
            $user->is_default_password = false;
        }
        $user->save();

        return redirect()->back()->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }

    public function resetPassword(User $user)
    {
        $colNumber = User::where('role', $user->role)->where('id', '<=', $user->id)->count();
        $passwordPlain = substr($user->email, 0, 4) . $colNumber;

        $user->password = Hash::make($passwordPlain);
        $user->is_default_password = true;
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil direset. Password baru: ' . $passwordPlain);
    }

    public function export($role)
    {
        return Excel::download(new \App\Exports\UsersExport($role), 'users_' . $role . '.xlsx');
    }
}
