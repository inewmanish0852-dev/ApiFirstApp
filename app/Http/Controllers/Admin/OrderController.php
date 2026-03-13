<?php
// app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', "%{$request->search}%")
                  ->orWhereHas('user', fn($q) =>
                      $q->where('name', 'like', "%{$request->search}%")
                  );
            });
        }
          
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->paginate(20)->withQueryString();

        $stats = [
            'total'      => Order::count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped'    => Order::where('status', 'shipped')->count(),
            'delivered'  => Order::where('status', 'delivered')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status'     => 'required|in:processing,shipped,delivered,cancelled',
            'tracking_id' => 'nullable|string|max:100',
        ]);

        $order->update([
            'status'       => $request->status,
            'tracking_id'  => $request->tracking_id ?? $order->tracking_id,
            'delivered_at' => $request->status === 'delivered' ? now() : $order->delivered_at,
        ]);

        return back()->with('success', "Order #{$order->order_number} status updated to {$request->status}.");
    }
}