<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


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
    // Optional: you can check if the lesson belongs to the course
    if ($lesson->course_id !== $course->id) {
        abort(404, 'Lesson not found in this course.');
    }

    $user =  Auth::user();

     // Guest users
     if (!$user) {
        abort(403, 'You must be logged in to view this lesson.');
    }

    // Simulated "paid" access: must come from Stripe success redirect
    if (request()->query('success') !== 'true') {
        abort(403, 'You must purchase this course to view lessons.');
    }

    // Teacher can always view their own lessons
    if ($user->id === $course->teacher_id) {
        return Inertia::render('Lessons/ShowLesson', [
            'course' => $course,
            'lesson' => $lesson,
        ]);
    }

    return Inertia::render('Lessons/ShowLesson', [
        'course' => $course,
        'lesson' => $lesson,
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

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'nullable|string',
        'video_url' => 'nullable|url',
        'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
    ]);

    if ($request->hasFile('pdf_file')) {
        $validated['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
    }

    $lesson->update($validated);

    return redirect()->route('courses.show', $course->id)->with('success', 'Lesson updated successfully!');
}



}
