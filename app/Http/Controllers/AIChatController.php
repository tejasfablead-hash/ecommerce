<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AIChatController extends Controller
{
    // Handle AI chat AJAX
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->message;

        // TODO: replace this with real AI logic
        $aiReply = "AI: You said -> " . $userMessage;

        return response()->json([
            'reply' => $aiReply
        ]);
    }
}
