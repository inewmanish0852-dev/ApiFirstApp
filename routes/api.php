<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ContactController;

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\NotificationController;

Route::get('/test', function () {
    return response()->json([
        'status' => 'API working'
    ]);
});

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::get('services',[ServiceController::class,'index']);
Route::get('services/{id}',[ServiceController::class,'show']);

Route::get('page/about',[PageController::class,'about']);
Route::get('page/terms',[PageController::class,'terms']);

Route::post('contact',[ContactController::class,'store']);

Route::middleware('auth:api')->group(function(){

    Route::put('update-profile', [AuthController::class, 'updateProfile'])->name('update-profile');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('change-password');

    Route::post('logout',[AuthController::class,'logout']);
    Route::get('user',[AuthController::class,'user'])->name('user');

    // Products
    Route::get('/products',             [ProductController::class, 'index']);
    Route::get('/products/{id}',        [ProductController::class, 'show']);
    Route::get('/products/category/{slug}', [ProductController::class, 'byCategory']);
    Route::get('/categories',           [ProductController::class, 'categories']);

    // Cart
    Route::get('/cart',              [CartController::class, 'index']);
    Route::post('/cart/add',         [CartController::class, 'add']);
    Route::post('/cart/update',      [CartController::class, 'update']);
    Route::delete('/cart/{id}',      [CartController::class, 'remove']);
    Route::delete('/cart',           [CartController::class, 'clear']);

    // Orders
    Route::get('/orders',            [OrderController::class, 'index']);
    Route::post('/orders',           [OrderController::class, 'store']);
    Route::get('/orders/{id}',       [OrderController::class, 'show']);
    Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice']);

    // Chat
    Route::get('/chats',             [ChatController::class, 'index']);
    Route::get('/chats/{id}/messages', [ChatController::class, 'messages']);
    Route::post('/chats/{id}/send',  [ChatController::class, 'send']);

    // Reviews
    Route::get('/products/{id}/reviews', [ReviewController::class, 'index']);
    Route::post('/reviews',          [ReviewController::class, 'store']);

    // Gallery
    Route::get('/gallery',           [GalleryController::class, 'index']);

    // Notifications
    Route::get('/notifications',     [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead']);
    Route::post('/notifications/read-all',  [NotificationController::class, 'markAllRead']);

});