<?php
// app/Http/Controllers/Admin/ChatController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $chats = Chat::with('user')
            ->orderByDesc('last_message_at')
            ->get();

        // Which chat is open (default = first)
        $activeChatId = $request->get('chat_id', $chats->first()?->id);
        $activeChat   = $chats->find($activeChatId);
        $messages     = collect();

        if ($activeChat) {
            $messages = $activeChat->messages()->orderBy('created_at')->get();
            // Mark user messages as read
            $activeChat->messages()->where('sender_type', 'user')->update(['is_read' => true]);
            $activeChat->update(['unread_admin' => 0]);
        }

        return view('admin.chat.index', compact('chats', 'activeChat', 'messages'));
    }

    // AJAX — load messages for a chat
    public function messages(Chat $chat)
    {
        $messages = $chat->messages()->orderBy('created_at')->get();
        $chat->messages()->where('sender_type', 'user')->update(['is_read' => true]);
        $chat->update(['unread_admin' => 0]);

        return response()->json([
            'status' => true,
            'data'   => $messages->map(fn($m) => [
                'id'           => $m->id,
                'sender_type'  => $m->sender_type,
                'message'      => $m->message,
                'time'         => $m->formatted_time,
                'date'         => $m->formatted_date,
            ]),
        ]);
    }

    // AJAX — admin sends a reply
    public function send(Request $request, Chat $chat)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $msg = ChatMessage::create([
            'chat_id'     => $chat->id,
            'sender_type' => 'admin',
            'message'     => $request->message,
            'is_read'     => false,
        ]);

        $chat->update([
            'last_message'    => $request->message,
            'last_message_at' => now(),
            'unread_user'     => $chat->unread_user + 1,
        ]);

        return response()->json([
            'status' => true,
            'data'   => [
                'id'          => $msg->id,
                'sender_type' => $msg->sender_type,
                'message'     => $msg->message,
                'time'        => $msg->formatted_time,
            ],
        ]);
    }
}