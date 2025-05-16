<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;




class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function view()
    {
        // ✅ Confirm the route/controller is hit
        // dd('🧭 Reached RegisterController@view');

        return Inertia::render('Auth/Register');
    }

    /**
     * Handle the registration request.
     */
    public function store(Request $request)
    {
        Log::info('📩 RegisterController@store was called');

        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name'  => 'required|string|max:255',
                'email'      => 'required|string|email|max:255|unique:users',
                'password'   => 'required|string|min:8|confirmed',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('❌ Validation failed', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'role'       => 'student',
            ]);
        } catch (\Exception $e) {
            Log::error('❌ User creation failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'User creation failed'], 500);
        }


        Auth::login($user);

        return redirect('/login')->with('success', 'Registration successful. Please log in.');
    }
}
