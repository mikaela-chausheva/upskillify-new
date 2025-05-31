<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    //LoginForm
    public function view()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Handle the login request.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);


    $user = User::where('email', $credentials['email'])->first();

    if (!$user) {
        return back()->withErrors([
            'email' => 'No account found with this email.',
        ])->onlyInput('email');
    }

    if (!Hash::check($credentials['password'], $user->password)) {
        return back()->withErrors([
            'password' => 'Incorrect password.',
        ])->onlyInput('email');
    }

    // If both checks passed, log the user in
    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->intended('/');
    }


    /**
     * Log the user out.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
