<?php
// app/Models/OrderItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'title',
        'price', 'quantity', 'size', 'image',
    ];

    protected $casts = ['price' => 'float'];

    // ── Relationships ─────────────────────────────────────────────────────
    public function order()   { return $this->belongsTo(Order::class); }
    public function product() { return $this->belongsTo(Product::class); }

    // ── Accessors ─────────────────────────────────────────────────────────
    public function getSubtotalAttribute(): float
    {
        return $this->price * $this->quantity;
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/placeholder.png');
    }
}