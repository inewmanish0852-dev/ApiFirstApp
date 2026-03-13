<?php
// database/migrations/2024_01_01_000009_create_notifications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            // null = broadcast to ALL users
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('icon')->default('🔔');
            $table->string('title');
            $table->text('body');
            $table->enum('type', ['order', 'chat', 'review', 'promo', 'general'])->default('general');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('notifications'); }
};
