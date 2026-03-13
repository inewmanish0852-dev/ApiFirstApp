<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'status',
        'payment_method', 'payment_status',
        'subtotal', 'delivery_charge', 'discount_amount', 'total',
        'shipping_name', 'shipping_phone', 'shipping_address',
        'shipping_city', 'shipping_state', 'shipping_pincode',
        'tracking_id', 'notes', 'delivered_at',
    ];

    protected $casts = [
        'delivered_at'    => 'datetime',
        'subtotal'        => 'float',
        'delivery_charge' => 'float',
        'discount_amount' => 'float',
        'total'           => 'float',
    ];

    // ── Relationships ─────────────────────────────────────────────────────
    public function user()  { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class); }

    // ── Accessors ─────────────────────────────────────────────────────────
    public function getItemsCountAttribute(): int
    {
        return $this->items()->sum('quantity');
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'delivered'  => 'green',
            'shipped'    => 'orange',
            'processing' => 'blue',
            'cancelled'  => 'red',
            default      => 'blue',
        };
    }

    // Tracking timeline for order detail page
    public function getTimelineAttribute(): array
    {
        $steps = [
            ['label' => 'Order Placed',    'status' => 'placed'],
            ['label' => 'Processing',      'status' => 'processing'],
            ['label' => 'Shipped',         'status' => 'shipped'],
            ['label' => 'Delivered',       'status' => 'delivered'],
        ];

        $doneUpto = match($this->status) {
            'processing' => 2,
            'shipped'    => 3,
            'delivered'  => 4,
            'cancelled'  => 1,
            default      => 1,
        };

        return collect($steps)->map(fn($s, $i) => array_merge($s, [
            'done' => ($i + 1) <= $doneUpto,
        ]))->toArray();
    }

    // ── Static Helpers ────────────────────────────────────────────────────
    public static function generateOrderNumber(): string
    {
        $year  = date('Y');
        $count = static::whereYear('created_at', $year)->count() + 1;
        return 'ORD-' . $year . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}