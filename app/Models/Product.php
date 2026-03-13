<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'slug', 'description',
        'price', 'original_price', 'discount', 'stock',
        'rating', 'reviews_count', 'image', 'images',
        'sizes', 'tags', 'is_featured', 'is_active',
    ];

    protected $casts = [
        'images'      => 'array',
        'sizes'       => 'array',
        'tags'        => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'price'       => 'float',
        'original_price' => 'float',
        'rating'      => 'float',
    ];

    // ── Relationships ─────────────────────────────────────────────────────
    public function category()   { return $this->belongsTo(Category::class); }
    public function reviews()    { return $this->hasMany(Review::class); }
    public function cartItems()  { return $this->hasMany(Cart::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }

    // ── Accessors ─────────────────────────────────────────────────────────
    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/placeholder.png');
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock <= 0)  return 'out_of_stock';
        if ($this->stock <= 5)  return 'low_stock';
        return 'in_stock';
    }

    public function getStockLabelAttribute(): string
    {
        return match($this->stock_status) {
            'out_of_stock' => 'Out of Stock',
            'low_stock'    => 'Low Stock',
            default        => 'In Stock',
        };
    }

    // ── Recalculate avg rating ────────────────────────────────────────────
    public function recalculateRating(): void
    {
        $avg = $this->reviews()->where('is_approved', true)->avg('rating') ?? 0;
        $cnt = $this->reviews()->where('is_approved', true)->count();
        $this->update([
            'rating'        => round($avg, 1),
            'reviews_count' => $cnt,
        ]);
    }

    // ── Scopes ────────────────────────────────────────────────────────────
    public function scopeActive($q)   { return $q->where('is_active', true); }
    public function scopeFeatured($q) { return $q->where('is_featured', true); }
}