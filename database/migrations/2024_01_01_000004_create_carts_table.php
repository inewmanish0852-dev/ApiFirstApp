<?php
// database/migrations/2024_01_01_000004_create_carts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->string('size')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'product_id', 'size']);
        });
    }
    public function down(): void { Schema::dropIfExists('carts'); }
};
