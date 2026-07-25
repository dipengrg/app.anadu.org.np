<?php

namespace App\Services;

use App\Models\CommitteeMember;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Log;

class AuthService
{
    /**
     * Handle the generation and sending logic for OTP.
     */
    public function generateAndSendOtp(string $memberId, string $phone): void
    {
        OtpVerification::where('mobile_number', $phone)->delete();

        $otpCode = random_int(1000, 9999);

        OtpVerification::create([
            'mobile_number' => $phone,
            'otp_code' => $otpCode,
            'expires_at' => now()->addMinutes(5),
        ]);

        $committeeMember = CommitteeMember::where('member_id', $memberId)
            ->whereHas('profile', function ($query) use ($phone): void {
                $query->where('phone', $phone);
            })
            ->first();

        if ($committeeMember) {
            Log::info("OTP for committee member {$memberId} on {$phone}: {$otpCode}");
        }
    }

    /**
     * Handle verification logic and issue a token if successful.
     * Returns the token string or null on failure.
     */
    public function verifyOtpAndCreateToken(string $memberId, string $phone, string $otpCode): ?string
    {
        $verification = OtpVerification::where('mobile_number', $phone)
            ->where('otp_code', $otpCode)
            ->where('expires_at', '>', now())
            ->first();

        if (! $verification) {
            return null;
        }

        $committeeMember = CommitteeMember::where('member_id', $memberId)
            ->whereHas('profile', function ($query) use ($phone): void {
                $query->where('phone', $phone);
            })
            ->first();

        if (! $committeeMember) {
            return null;
        }

        $verification->delete();

        return $committeeMember->createToken('anadu-mobile-session')->plainTextToken;
    }
}