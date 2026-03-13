<?php
// app/Models/Gallery.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'gallery';

    protected $fillable = ['title', 'image', 'category', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    // ── Accessors ─────────────────────────────────────────────────────────
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }

    // ── Scopes ────────────────────────────────────────────────────────────
    public function scopeActive($q)    { return $q->where('is_active', true); }
    public function scopeOrdered($q)   { return $q->orderBy('sort_order'); }
}