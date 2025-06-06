<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;


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

        $user = Auth::user(); // returns the authenticated user instance or null
        // dd($user);
        // dd($user);
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Check if the user is a teacher
    if ($user->role !== 'teacher') {
        abort(403, 'Only teachers can create courses.');
    }
        $request->validate([
           'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'photo_url' => 'required|string|max:255'
        ]);
        // dd($request);

        // $user = auth()->User();

        $course = Course::create([
            'title' => $request->title,
            'slug' =>Str::slug($request->title),
            'description' => $request->description,
            'photo_url' => $request->photo_url,
            'price' => $request->price,
            'teacher_id' => $user->id,
            'is_active' => true
        ]);


        return redirect('/')->with('success', 'Course created successfully!');

    }

    public function viewListCourses()
    {
        $courses = Course::all();

        return Inertia::render('Courses/ListCourses',[
            'courses' => $courses
        ]);
    }

    public function viewSingleCourse(Course $course)
    {
        $course->load('lessons');

        $isEnrolled = Auth::check() && Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->exists();

        if (request()->query('success') === 'true' && Auth::check() && !$isEnrolled) {
            Enrollment::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
            ]);

            session()->flash('success', 'Thank you! You are now enrolled.');
            $isEnrolled = true; // update state after inserting
        }

        return Inertia::render('Courses/ShowCourse', [
            'course' => $course,
            'authUser' => Auth::user(),
            'isEnrolled' => $isEnrolled,
        ]);
    }



    public function myCourses()
    {
        $user = Auth::user();

        $createdCourses = $user->createdCourses()->withCount('lessons')->get();
        $enrolledCourses = $user->enrolledCourses()->withCount('lessons')->get();

        return Inertia::render('Courses/MyCourses', [
            'createdCourses' => $createdCourses,
            'enrolledCourses' => $enrolledCourses,
            'auth' => [
            'user' => $user,
            ],
        ]);
    }

}
