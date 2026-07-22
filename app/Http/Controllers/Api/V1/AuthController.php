<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\SendOtpRequest;
use App\Http\Requests\Api\V1\VerifyOtpRequest;
use App\Models\User;
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
        $this->authService->generateAndSendOtp($request->validated()['mobile_number']);

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
        // The service processes validation details and returns either a token string or null
        $token = $this->authService->verifyOtpAndCreateToken(
            $request->mobile_number,
            $request->otp_code
        );

        if (! $token) {
            return response()->json([
                'status' => 'error',
                'message' => __('auth.otp.invalid'),
            ], 422);
        }

        // Resolve user record cleanly for context response payload
        $user = User::where('mobile_number', $request->mobile_number)->first();

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => [
                'name' => $user->profile?->name,
                'mobile' => $user->mobile_number,
                'role' => $user->role,
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
