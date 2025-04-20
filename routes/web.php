<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return Inertia::render('Home'); // This will render the Home.vue component
})->name('home'); // Give it a name 'home'

//Register
Route::get('/register', [RegisterController::class, 'view']);
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Login
// Route::get('/login', [LoginController::class, 'view']);
// Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::get('/login', [LoginController::class, 'view'])->name('login.view');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

// Logout
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Dashboard
// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard'); // Assuming you have a Dashboard.vue component
// })->name('dashboard');
