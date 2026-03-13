<?php
// app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'product_id', 'rating', 'comment', 'is_approved'];

    protected $casts = ['is_approved' => 'boolean'];

    // ── Relationships ─────────────────────────────────────────────────────
    public function user()    { return $this->belongsTo(User::class); }
    public function product() { return $this->belongsTo(Product::class); }

    // ── Auto-recalculate product rating ───────────────────────────────────
    protected static function booted(): void
    {
        static::saved(fn($r)   => $r->product->recalculateRating());
        static::deleted(fn($r) => $r->product->recalculateRating());
    }

    // ── Scopes ────────────────────────────────────────────────────────────
    public function scopeApproved($q) { return $q->where('is_approved', true); }
}