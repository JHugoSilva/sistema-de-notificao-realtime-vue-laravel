<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LikeCommentController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get('send-mail', 'testMail');
    Route::post('forget-password-request', 'forgetPasswordRequest');
    Route::post('forget-password', 'verifyAndChangePassword');

    Route::middleware('auth:sanctum')->group(function(){
        Route::get('profile', 'getProfile');
        Route::delete('logout', 'logout');
        Route::put('change-password', 'changePassword');
        Route::put('update-profile', 'updateProfile');
    });
});

Route::prefix('user')->middleware('auth:sanctum')->group(function(){
    Route::apiResource('posts', PostController::class);
    Route::get('posts-public', [PostController::class, 'publicPosts']);

    Route::controller(LikeCommentController::class)->group(function(){
        Route::post('comments', 'postComment');
        Route::get('like/{postId}', 'likeUnLike');


    });
});
