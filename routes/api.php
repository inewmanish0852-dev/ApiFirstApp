<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ContactController;

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

});