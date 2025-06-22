<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;



class LessonController extends Controller
{
    public function create(Course $course)
    {
        // Only teachers can create lessons for their own courses
        if (Auth::id() !== $course->teacher_id) {
            abort(403, 'Unauthorized');
        }

        return Inertia::render('Lessons/CreateLesson', [
            'course' => $course
        ]);
    }

    public function store(Request $request, Course $course)
    {
        if (Auth::id() !== $course->teacher_id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('pdf_file')) {
            $validated['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
        }

        $validated['course_id'] = $course->id;

        Lesson::create($validated);

        return redirect()->route('courses.show', $course->id)->with('success', 'Lesson created successfully!');
    }

    public function show(Course $course, Lesson $lesson)
{
    // check if the lesson belongs to the course
    if ($lesson->course_id !== $course->id) {
        abort(404, 'Lesson not found in this course.');
    }

    $user =  Auth::user();

     // Guest users
    if (!$user) {
        abort(403, 'You must be logged in to view this lesson.');
    }

    // Check if the user is a techer or is enrolled by student
    if ($user->id !== $course->teacher_id) {
        $enrolled = Enrollment::where('user_id', $user->id)
                              ->where('course_id', $course->id)
                              ->exists();

        if (!$enrolled) {
            abort(403, 'You must purchase this course to view lessons.');
        }
    }

    // Return view
    return Inertia::render('Lessons/ShowLesson', [
        'course' => $course,
        'lesson' => $lesson,
        'authUser' => Auth::user()
    ]);
}

public function edit(Course $course, Lesson $lesson)
{
    // Only the teacher can edit
    if (Auth::id() !== $course->teacher_id || $lesson->course_id !== $course->id) {
        abort(403);
    }

    return Inertia::render('Lessons/EditLesson', [
        'course' => $course,
        'lesson' => $lesson,
    ]);
}

public function update(Request $request, Course $course, Lesson $lesson)
{
    if (Auth::id() !== $course->teacher_id || $lesson->course_id !== $course->id) {
        abort(403);
    }
    // dd($lesson);
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'nullable|string',
        'video_url' => 'nullable|url',
        'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
    ]);

    if ($request->fails()) {
        dd($request->all());
    }

    if ($request->hasFile('pdf_file')) {
        $validated['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
    } else {
        unset($validated['pdf_file']);

    }

    $lesson->update($validated);

    return redirect()->route('courses.show', $course->id)->with('success', 'Lesson updated successfully!');
}



}
