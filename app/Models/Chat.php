<?php
// app/Models/Chat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'user_id', 'subject', 'is_open',
        'unread_admin', 'unread_user',
        'last_message', 'last_message_at',
    ];

    protected $casts = [
        'is_open'        => 'boolean',
        'last_message_at' => 'datetime',
    ];

    // ── Relationships ─────────────────────────────────────────────────────
    public function user()     { return $this->belongsTo(User::class); }
    public function messages() { return $this->hasMany(ChatMessage::class); }

    // ── Scopes ────────────────────────────────────────────────────────────
    public function scopeOpen($q) { return $q->where('is_open', true); }
}