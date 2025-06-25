<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;

class MessageController extends Controller
{
    public function index($courseId)
    {
        return Message::where('course_id', $courseId)
            ->with(['user:id,first_name,last_name'])
            ->orderBy('created_at')
            ->get();
    }

    public function store(Request $request, $courseId)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $message = Message::create([
            'user_id' => auth()->id(),
            'course_id' => $courseId,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message, auth()->user()))->toOthers();

        return response()->json(['status' => 'Message sent']);
    }
}
