<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Prevent duplicate ratings from the same user
        $existing = $course->ratings()->where('user_id', Auth::id())->first();
        if ($existing) {
            $existing->update($request->only('rating', 'comment'));
        } else {
            $course->ratings()->create([
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
        }

        return response()->json(['message' => 'Rating submitted successfully.']);
    }
}
