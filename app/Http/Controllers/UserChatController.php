<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserChatController extends Controller
{
      private function adminId()
    {
        return 1; // change if needed
    }
    public function index(){
        return view('Ecommerce.Pages.chat');
    }

    public function fetchMessages()
    {
        $userId  = Auth::id();
        $adminId = $this->adminId();

        $messages = ChatMessage::where(function ($q) use ($userId, $adminId) {
            $q->where('sender_id', $userId)
              ->where('receiver_id', $adminId);
        })->orWhere(function ($q) use ($userId, $adminId) {
            $q->where('sender_id', $adminId)
              ->where('receiver_id', $userId);
        })
        ->orderBy('id')
        ->get();

        // mark admin messages as seen
        ChatMessage::where('sender_id', $adminId)
            ->where('receiver_id', $userId)
            ->update(['is_seen' => 1]);

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        ChatMessage::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $this->adminId(),
            'message'     => $request->message,
            'is_seen'     => 0
        ]);

        return response()->json(['status' => true]);
    }
    public function unreadCount()
{
        $check = Auth::check();
        $id = Auth::id();
    if (!$check) {
        return response()->json(['count' => 0]);
    }

    $adminId = 1; // your admin id

    $count = ChatMessage::where('sender_id', $adminId)
        ->where('receiver_id', $id)
        ->where('is_seen', 0)
        ->count();

    return response()->json(['count' => $count]);
}
public function unreadMessages()
{
    if (!Auth::check()) {
        return response()->json([]);
    }

    $adminId = 1;
    $userId = Auth::id();

    $messages = ChatMessage::where('sender_id', $adminId)
        ->where('receiver_id', $userId)
        ->where('is_seen', 0)
        ->latest()
        ->limit(10)
        ->get(['id', 'message', 'created_at']);

    return response()->json($messages);
}

}
