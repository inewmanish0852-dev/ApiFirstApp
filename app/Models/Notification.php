<?php
// app/Models/Notification.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'icon', 'title', 'body', 'type', 'is_read'];

    protected $casts = ['is_read' => 'boolean'];

    // ── Relationships ─────────────────────────────────────────────────────
    public function user() { return $this->belongsTo(User::class); }

    // ── Accessors ─────────────────────────────────────────────────────────
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    // ── Scopes ────────────────────────────────────────────────────────────
    public function scopeUnread($q) { return $q->where('is_read', false); }

    // Returns notifications for a specific user + broadcast notifications
    public function scopeForUser($q, int $userId)
    {
        return $q->where(function ($q) use ($userId) {
            $q->where('user_id', $userId)->orWhereNull('user_id');
        });
    }
}