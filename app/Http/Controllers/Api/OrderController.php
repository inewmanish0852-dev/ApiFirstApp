<?php
// app/Http/Controllers/Api/OrderController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class OrderController extends Controller
{
    use ResponseTrait;
    private function orders(): array
    {
        return [
            [
                'id'           => 1,
                'order_number' => 'ORD-2024-001',
                'status'       => 'delivered',
                'status_label' => 'Delivered',
                'total'        => 6597,
                'items_count'  => 3,
                'placed_at'    => '2024-01-10',
                'delivered_at' => '2024-01-14',
                'address'      => '123 Main St, Mumbai, MH 400001',
                'items'        => [
                    ['product_id' => 1, 'title' => 'Wireless Headphones', 'qty' => 2, 'price' => 2999, 'image' => 'https://via.placeholder.com/200x200?text=Headphones'],
                    ['product_id' => 2, 'title' => 'Premium Cotton T-Shirt', 'qty' => 1, 'price' => 599, 'image' => 'https://via.placeholder.com/200x200?text=T-Shirt'],
                ],
                'timeline'     => [
                    ['label' => 'Order Placed',   'done' => true,  'date' => 'Jan 10, 2:30 PM'],
                    ['label' => 'Processing',     'done' => true,  'date' => 'Jan 10, 4:00 PM'],
                    ['label' => 'Shipped',        'done' => true,  'date' => 'Jan 12, 10:00 AM'],
                    ['label' => 'Delivered',      'done' => true,  'date' => 'Jan 14, 2:00 PM'],
                ],
            ],
            [
                'id'           => 2,
                'order_number' => 'ORD-2024-002',
                'status'       => 'shipped',
                'status_label' => 'Shipped',
                'total'        => 49999,
                'items_count'  => 1,
                'placed_at'    => '2024-01-14',
                'delivered_at' => null,
                'address'      => '456 Park Ave, Delhi, DL 110001',
                'items'        => [
                    ['product_id' => 3, 'title' => 'Smartphone Pro Max', 'qty' => 1, 'price' => 49999, 'image' => 'https://via.placeholder.com/200x200?text=Smartphone'],
                ],
                'timeline'     => [
                    ['label' => 'Order Placed',   'done' => true,  'date' => 'Jan 14, 10:00 AM'],
                    ['label' => 'Processing',     'done' => true,  'date' => 'Jan 14, 12:00 PM'],
                    ['label' => 'Shipped',        'done' => true,  'date' => 'Jan 15, 9:00 AM'],
                    ['label' => 'Delivered',      'done' => false, 'date' => 'Expected Jan 18'],
                ],
            ],
            [
                'id'           => 3,
                'order_number' => 'ORD-2024-003',
                'status'       => 'processing',
                'status_label' => 'Processing',
                'total'        => 15596,
                'items_count'  => 3,
                'placed_at'    => '2024-01-16',
                'delivered_at' => null,
                'address'      => '789 Lake Rd, Bangalore, KA 560001',
                'items'        => [
                    ['product_id' => 1, 'title' => 'Wireless Headphones', 'qty' => 1, 'price' => 2999, 'image' => 'https://via.placeholder.com/200x200?text=Headphones'],
                    ['product_id' => 4, 'title' => 'Leather Backpack',    'qty' => 1, 'price' => 3499, 'image' => 'https://via.placeholder.com/200x200?text=Backpack'],
                    ['product_id' => 5, 'title' => 'Smart Watch Series 5', 'qty' => 1, 'price' => 8999, 'image' => 'https://via.placeholder.com/200x200?text=SmartWatch'],
                ],
                'timeline'     => [
                    ['label' => 'Order Placed',   'done' => true,  'date' => 'Jan 16, 11:00 AM'],
                    ['label' => 'Processing',     'done' => true,  'date' => 'Jan 16, 1:00 PM'],
                    ['label' => 'Shipped',        'done' => false, 'date' => 'Expected Jan 17'],
                    ['label' => 'Delivered',      'done' => false, 'date' => 'Expected Jan 20'],
                ],
            ],
        ];
    }

    public function index()
    {
        return $this->success('Orders fetched successfully', $this->orders());
    }

    public function store(Request $request)
    {
        $request->validate([
            'address'      => 'required|string',
            'phone'        => 'required|string',
            'payment_method' => 'required|string',
        ]);

        return $this->success('Order placed successfully!', [
            'status'  => true,
            'message' => 'Order placed successfully!',
            'data'    => [
                'id'           => rand(100, 999),
                'order_number' => 'ORD-2024-' . rand(100, 999),
                'status'       => 'processing',
                'total'        => $request->total ?? 0,
                'placed_at'    => now()->toDateString(),
            ],
        ]);
    }

    public function show($id)
    {
        $order = collect($this->orders())->firstWhere('id', (int)$id);
        if (!$order) {
            return $this->error('Order not found', 404);
        }
        return $this->success('Order fetched successfully', $order);
    }

    public function invoice($id)
    {
        $order = collect($this->orders())->firstWhere('id', (int)$id);
        if (!$order) {
            return $this->error('Order not found', 404);
        }

        $subtotal = collect($order['items'])->sum(fn($i) => $i['price'] * $i['qty']);
        $delivery = $subtotal > 500 ? 0 : 99;

        return $this->success('Invoice fetched successfully', [
            [
                'invoice_number' => 'INV-2024-' . str_pad($id, 3, '0', STR_PAD_LEFT),
                'order_number'   => $order['order_number'],
                'date'           => $order['placed_at'],
                'status'         => 'paid',
                'items'          => $order['items'],
                'subtotal'       => $subtotal,
                'delivery'       => $delivery,
                'total'          => $subtotal + $delivery,
                'address'        => $order['address'],
            ],
        ]);
    }
}