<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;

/**
 * API Routes for Mobile App Authentication
 * 
 * This file defines the routes for the mobile app's authentication flow.
 * It includes endpoints for requesting an OTP, verifying the OTP, and managing authenticated sessions.
 * 
 * The routes are versioned under 'v1' and grouped under the 'user' prefix.
 * 
 * @package App\Routes\Api
 */
Route::prefix('v1')->group(function () {
    // Routes for users
    Route::prefix('user')->group(function () {
        Route::post('/otp/request', [AuthController::class, 'requestOtp']);        
        Route::post('/otp/verify', [AuthController::class, 'verifyOtp']);

        // Authenticated Session Endpoints (Requires Bearer Token)
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/profile', [AuthController::class, 'profile']);
        });
    });
});
