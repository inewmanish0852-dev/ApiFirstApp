<?php
// app/Http/Controllers/Api/NotificationController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

class NotificationController extends Controller
{
    use ApiResponse;
    private function notifications(): array
    {
        return [
            ['id' => 1, 'icon' => '📦', 'title' => 'Order Shipped!',        'body' => 'Your order ORD-2024-002 is on its way. Track now.',     'time' => '2 min ago',  'read' => false, 'type' => 'order'],
            ['id' => 2, 'icon' => '💬', 'title' => 'New Message',           'body' => 'Support Team replied to your query.',                  'time' => '15 min ago', 'read' => false, 'type' => 'chat'],
            ['id' => 3, 'icon' => '🎉', 'title' => 'Order Confirmed!',      'body' => 'Order ORD-2024-003 has been placed successfully.',      'time' => '1 hour ago', 'read' => true,  'type' => 'order'],
            ['id' => 4, 'icon' => '⭐', 'title' => 'Rate Your Purchase',    'body' => 'How was your experience with Wireless Headphones?',     'time' => '1 day ago',  'read' => true,  'type' => 'review'],
            ['id' => 5, 'icon' => '🎁', 'title' => 'Special Offer!',        'body' => 'Get 30% off on Electronics today only. Shop now!',      'time' => '2 days ago', 'read' => true,  'type' => 'promo'],
        ];
    }

    public function index()
    {
        $all    = $this->notifications();
        $unread = collect($all)->where('read', false)->count();

        return $this->success([
            'notifications' => $all,
            'unread_count'  => $unread,
        ], 'Notifications fetched successfully');
    }

    public function markRead($id)
    {
        return $this->success([], 'Marked as read');
    }

    public function markAllRead()
    {
        return $this->success([], 'All marked as read');
    }
}