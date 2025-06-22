<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

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

        // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Разделяме пълното име на две части: първо и фамилно
        $fullName = $googleUser->getName();
        $nameParts = explode(' ', $fullName, 2); // ['first_name', 'last_name']

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'first_name' => $nameParts[0] ?? '',
                'last_name' => $nameParts[1] ?? '',
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(str()->random(24)), // безопасна временна парола
            ]
        );

        Auth::login($user);

        return redirect()->route('courses.list');
    }

}
