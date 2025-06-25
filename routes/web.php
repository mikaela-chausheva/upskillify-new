<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Api\MessageController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsAdmin;


// Dashboard
Route::get('/', function () {
    return Inertia::render('Home', [
       'authUser' => Auth::user(),
    ]);
})->name('home'); // Give it a name 'home'

//Register
Route::get('/register', [RegisterController::class, 'view']);
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Login
Route::get('/login', [LoginController::class, 'view'])->name('login.view');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
// Login with google
Route::get('/auth/google/redirect', [LoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('google.callback');


// Logout
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Courses
Route::middleware(['auth'])->group(function () {
    Route::get('/createCourse', [CourseController::class, 'viewCreate'])->name('course.viewCreate');
    Route::post('/storeCourse', [CourseController::class, 'storeCourse'])->name('course.store');
    Route::get('/my-courses', [CourseController::class, 'myCourses'])->name('courses.mine');

});

Route::get('/courses', [CourseController::class, 'viewListCourses'])->name('courses.list');
Route::get('/courses/{course}', [CourseController::class, 'viewSingleCourse'])->name('courses.show');

// Lessons
Route::middleware(['auth'])->group(function () {
    Route::get('/courses/{course}/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('/courses/{course}/lessons', [LessonController::class, 'store'])->name('lessons.store');
    Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
    Route::get('/courses/{course}/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/courses/{course}/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
});
// Ratings
Route::post('/courses/{course}/ratings', [RatingController::class, 'store'])->middleware('auth');

// Admin
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminUserController::class, 'dashboard'])->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('admin.users.updateRole');
});
// Payment
Route::post('/courses/{course}/checkout', [PaymentController::class, 'createCheckoutSession'])
    ->middleware('auth')
    ->name('courses.checkout');
// Chat
Route::middleware('auth')->group(function () {
    Route::get('/courses/{id}/messages', [MessageController::class, 'index']);
    Route::post('/courses/{id}/messages', [MessageController::class, 'store']);
});



