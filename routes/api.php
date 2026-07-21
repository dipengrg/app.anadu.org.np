<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserManagementController;

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
    // Public Authentication Endpoints
    Route::post('/otp/request', [AuthController::class, 'requestOtp']);        
    Route::post('/otp/verify', [AuthController::class, 'verifyOtp']);

    // Authenticated Session Endpoints (Requires Bearer Token)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);

        // Only Admins can manage users
        Route::middleware('role:admin')->group(function () {
            Route::get('/users', [UserManagementController::class, 'index']);
            Route::get('/users/{user}', [UserManagementController::class, 'show']);
            Route::post('/users', [UserManagementController::class, 'store']);
            Route::put('/users/{user}', [UserManagementController::class, 'update']);
            Route::delete('/users/{user}', [UserManagementController::class, 'destroy']);
        });
    });
});
