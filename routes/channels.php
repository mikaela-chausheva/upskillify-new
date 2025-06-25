<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('course.{courseId}', function ($user, $courseId) {
    return $user->enrolledCourses->contains($courseId)
        || $user->createdCourses->contains('id', $courseId);
});
