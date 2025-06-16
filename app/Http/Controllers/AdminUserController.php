<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class AdminUserController extends Controller
{

    public function index()
    {
        $users = User::select('id', 'first_name','last_name', 'email', 'role')->get();
        // dd('test');
        return Inertia::render('Admin/UserList', ['users' => $users]);
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,teacher,student',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'Role updated successfully.');
    }
}
