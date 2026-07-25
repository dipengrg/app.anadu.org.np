<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\SendOtpRequest;
use App\Http\Requests\Api\V1\VerifyOtpRequest;
use App\Models\CommitteeMember;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    // Laravel automatically injects the service class here
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Step 1: Request OTP
     */
    public function requestOtp(SendOtpRequest $request)
    {
        $this->authService->generateAndSendOtp(
            $request->validated()['member_id'],
            $request->validated()['phone']
        );

        return response()->json([
            'status' => 'success',
            'message' => __('auth.otp.sent'),
        ], 200);
    }

    /**
     * Step 2: Verify OTP & Issue Token
     */
    public function verifyOtp(VerifyOtpRequest $request)
    {
        $token = $this->authService->verifyOtpAndCreateToken(
            $request->member_id,
            $request->phone,
            $request->otp_code
        );

        if (! $token) {
            return response()->json([
                'status' => 'error',
                'message' => __('auth.otp.invalid'),
            ], 422);
        }

        $committeeMember = CommitteeMember::where('member_id', $request->member_id)
            ->whereHas('profile', function ($query) use ($request): void {
                $query->where('phone', $request->phone);
            })
            ->with('profile')
            ->first();

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => [
                'name' => $committeeMember?->profile?->name,
                'member_id' => $committeeMember?->member_id,
                'phone' => $committeeMember?->profile?->phone,
                'role' => $committeeMember?->role,
            ],
        ], 200);
    }

    /**
     * Guard Check Context
     */
    public function profile(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => $request->user(),
        ]);
    }
}
