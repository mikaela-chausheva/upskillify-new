<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controller\Auth;
use Illuminate\Support\Facades\Hash;




class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function view()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle the registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        // dd($request);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student'
        ]);
        // dd($user);

        // Auth::login($user);

        return redirect('/register');
    }
}
