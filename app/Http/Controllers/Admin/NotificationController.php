<?php
// app/Http/Controllers/Admin/NotificationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('user')->latest()->paginate(30);
        $users         = User::where('role', 'user')->orderBy('name')->get();
        return view('admin.notifications.index', compact('notifications', 'users'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'body'    => 'required|string',
            'type'    => 'required|in:order,chat,review,promo,general',
            'send_to' => 'required|in:all,specific',
            'user_id' => 'nullable|required_if:send_to,specific|exists:users,id',
        ]);

        Notification::create([
            'user_id' => $request->send_to === 'specific' ? $request->user_id : null,
            'icon'    => match($request->type) {
                'order'  => '📦',
                'chat'   => '💬',
                'review' => '⭐',
                'promo'  => '🎁',
                default  => '🔔',
            },
            'title' => $request->title,
            'body'  => $request->body,
            'type'  => $request->type,
        ]);

        return back()->with('success', 'Notification sent successfully!');
    }
}