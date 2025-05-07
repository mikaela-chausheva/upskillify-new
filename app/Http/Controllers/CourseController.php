<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Str;




class CourseController extends Controller
{
    /**
     * Show the registration form.
     */
    public function viewCreate()
    {
        return Inertia::render('Courses/CreateCourse');
    }

    /**
     * Handle the registration request.
     */
    public function storeCourse(Request $request)
    {
        $request->validate([
           'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            // 'teacher_id' => 'required|exists:users,id',
        ]);
        // dd($request);

        $course = Course::create([
            'title' => $request->title,
            'slug' =>Str::slug($request->title),
            'description' => $request->description,
            'price' => $request->price,
            'teacher_id' => 1,
            'is_active' => true
        ]);

        return redirect('/');
    }
}
