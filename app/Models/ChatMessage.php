<?php
// app/Models/ChatMessage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['chat_id', 'sender_type', 'message', 'is_read'];

    protected $casts = ['is_read' => 'boolean'];

    // ── Relationships ─────────────────────────────────────────────────────
    public function chat() { return $this->belongsTo(Chat::class); }

    // ── Accessors ─────────────────────────────────────────────────────────
    public function getFormattedTimeAttribute(): string
    {
        return $this->created_at->format('h:i A');
    }

    public function getFormattedDateAttribute(): string
    {
        if ($this->created_at->isToday())     return 'Today';
        if ($this->created_at->isYesterday()) return 'Yesterday';
        return $this->created_at->format('d M Y');
    }
}