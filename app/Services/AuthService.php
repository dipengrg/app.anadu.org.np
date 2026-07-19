<?php

namespace App\Services;

use App\Models\User;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Log;

class AuthService
{
    /**
     * Handle the generation and sending logic for OTP.
     */
    public function generateAndSendOtp(string $mobileNumber): void
    {
        // 1. Clear out any old unexpired OTPs for this number
        OtpVerification::where('mobile_number', $mobileNumber)->delete();

        // 2. Generate a secure 6-digit code
        $otpCode = random_int(100000, 999999);

        // 3. Save the temporary transaction row
        OtpVerification::create([
            'mobile_number' => $mobileNumber,
            'otp_code'      => $otpCode,
            'expires_at'    => now()->addMinutes(5),
        ]);

        // 4. Defensive check: Only trigger SMS if the user exists and is active
        $user = User::where('mobile_number', $mobileNumber)->where('is_active', true)->first();

        if ($user) {
            // TODO: Integrate local SMS Gateway here
            Log::info("OTP for {$mobileNumber}: {$otpCode}");
        }
    }

    /**
     * Handle verification logic and issue a token if successful.
     * Returns the token string or null on failure.
     */
    public function verifyOtpAndCreateToken(string $mobileNumber, string $otpCode): ?string
    {
        // 1. Fetch active verification instance
        $verification = OtpVerification::where('mobile_number', $mobileNumber)
            ->where('otp_code', $otpCode)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return null;
        }

        // 2. Verify permanent resident status
        $user = User::where('mobile_number', $mobileNumber)->where('is_active', true)->first();

        if (!$user) {
            return null;
        }

        // 3. Burn the used validation token immediately
        $verification->delete();

        // 4. Generate long-lived Sanctum token
        return $user->createToken('anadu-mobile-session')->plainTextToken;
    }
}