<?php

namespace App\Http\Controllers;

use App\Models\AiChatMessage;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AIChatController extends Controller
{
   public function ask(Request $request, AIService $ai)
    {
         $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = trim($validated['message']);

        // 2️⃣ Get user id (guest allowed)
        $userId = Auth::id();

        // 3️⃣ Load last chat history (context)
        $context = [];
        if ($userId) {
            $history = AiChatMessage::where('user_id', $userId)
                ->latest()
                ->limit(6)
                ->get()
                ->reverse();

            foreach ($history as $chat) {
                $context[] = [
                    'role' => 'user',
                    'content' => $chat->message
                ];
                $context[] = [
                    'role' => 'assistant',
                    'content' => $chat->reply
                ];
            }
        }

        try {
            // 4️⃣ Ask AI
            $reply = $ai->ask($userMessage, $context);

            // 5️⃣ Basic sanitization
            $reply = strip_tags($reply);

            // 6️⃣ Save chat
            AiChatMessage::create([
                'user_id' => $userId,
                'message' => $userMessage,
                'reply'   => $reply,
            ]);

            // 7️⃣ Return response
            return response()->json([
                'status' => true,
                'reply'  => $reply,
            ]);

        } catch (\Throwable $e) {

            // 8️⃣ Log error
            Log::error('AI Chat Error', [
                'message' => $e->getMessage(),
                'user_id' => $userId,
            ]);

            return response()->json([
                'status' => false,
                'reply'  => 'Sorry, I am temporarily unavailable. Please try again.',
            ], 500);
        }
    }
}
