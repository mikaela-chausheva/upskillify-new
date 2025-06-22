<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use Inertia\Inertia;

class AdminUserController extends Controller
{

    public function dashboard()
    {
        $userStats = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role');

        $coursesCount = Course::count();

        return Inertia::render('Admin/Dashboard', [
            'userStats' => $userStats,
            'coursesCount' => $coursesCount,
        ]);
    }

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
