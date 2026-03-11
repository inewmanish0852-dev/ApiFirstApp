<?php
// app/Http/Controllers/Api/ChatController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class ChatController extends Controller
{
    use ApiResponse;
    public function index()
    {
        return $this->success('Chats fetched successfully', [
            [
                [
                    'id'           => 1,
                    'name'         => 'Support Team',
                    'avatar'       => 'ST',
                    'color'        => '#27AE60',
                    'last_message' => 'Your order has been shipped!',
                    'time'         => '2 min ago',
                    'unread'       => 2,
                    'online'       => true,
                ],
                [
                    'id'           => 2,
                    'name'         => 'Admin',
                    'avatar'       => 'AD',
                    'color'        => '#E67E22',
                    'last_message' => 'Welcome to MyApp! How can we help?',
                    'time'         => '1 day ago',
                    'unread'       => 0,
                    'online'       => false,
                ],
                [
                    'id'           => 3,
                    'name'         => 'Bot Assistant',
                    'avatar'       => '🤖',
                    'color'        => '#9B59B6',
                    'last_message' => 'Hi! I can help you track your orders.',
                    'time'         => '3 days ago',
                    'unread'       => 0,
                    'online'       => true,
                ],
            ],
        ]);
    }

    public function messages($id)
    {
        $messages = [
            1 => [
                ['id' => 1, 'sender' => 'them', 'text' => 'Hello! How can we help you today?',          'time' => '2:30 PM', 'date' => 'Today'],
                ['id' => 2, 'sender' => 'me',   'text' => 'Hi! What is the status of my order #002?',   'time' => '2:31 PM', 'date' => 'Today'],
                ['id' => 3, 'sender' => 'them', 'text' => 'Your order has been shipped! Tracking: TRK123456', 'time' => '2:32 PM', 'date' => 'Today'],
                ['id' => 4, 'sender' => 'me',   'text' => 'Thank you! 🙏',                              'time' => '2:33 PM', 'date' => 'Today'],
                ['id' => 5, 'sender' => 'them', 'text' => 'You\'re welcome! Let us know if you need anything else.', 'time' => '2:34 PM', 'date' => 'Today'],
            ],
            2 => [
                ['id' => 1, 'sender' => 'them', 'text' => 'Welcome to MyApp! How can we help you?',     'time' => 'Yesterday', 'date' => 'Yesterday'],
                ['id' => 2, 'sender' => 'me',   'text' => 'Thanks! I just registered.',                 'time' => 'Yesterday', 'date' => 'Yesterday'],
                ['id' => 3, 'sender' => 'them', 'text' => 'Great! Check out our latest products. 🛍️',  'time' => 'Yesterday', 'date' => 'Yesterday'],
            ],
            3 => [
                ['id' => 1, 'sender' => 'them', 'text' => 'Hi! I am your order tracking assistant. 🤖', 'time' => '3 days ago', 'date' => '3 days ago'],
                ['id' => 2, 'sender' => 'me',   'text' => 'Can you track order ORD-2024-002?',          'time' => '3 days ago', 'date' => '3 days ago'],
                ['id' => 3, 'sender' => 'them', 'text' => 'Order ORD-2024-002 is currently being shipped. Expected delivery: Jan 18.', 'time' => '3 days ago', 'date' => '3 days ago'],
            ],
        ];

        return $this->success('Messages fetched successfully', $messages[(int)$id] ?? []);
    }

    public function send(Request $request, $id)
    {
        $request->validate(['message' => 'required|string']);

        return $this->success('Message sent successfully', [
            'id'     => rand(100, 999),
            'sender' => 'me',
            'text'   => $request->message,
            'time'   => now()->format('h:i A'),
            'date'   => 'Today',
        ]);
    }
}