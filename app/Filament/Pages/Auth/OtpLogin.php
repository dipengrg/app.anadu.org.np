<?php

namespace App\Filament\Pages\Auth;

use App\Livewire\Forms\SendOtpForm;
use App\Livewire\Forms\VerifyOtpForm;
use App\Models\OtpVerification;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\SimplePage;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class OtpLogin extends SimplePage
{
    public SendOtpForm $sendForm;
    public VerifyOtpForm $verifyForm;
    public bool $otpSent = false;

    protected string $view = 'filament.pages.auth.otp-login';

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }
    }

    public function getTitle(): string|Htmlable
    {
        return 'Administrative Panel';
    }

    public function getHeading(): string|Htmlable|null
    {
        return $this->otpSent ? 'Enter OTP' : 'Login with Mobile Number';
    }

    public function sendOtp(): void
    {
        $this->sendForm->validate();

        $mobileNumber = $this->sendForm->mobileNumber;

        $user = User::query()
            ->where('mobile_number', $mobileNumber)
            ->where('role', 'admin')
            ->first();

        if ($user) {
            $code = (string) random_int(100000, 999999);

            OtpVerification::updateOrCreate(
                ['mobile_number' => $mobileNumber],
                [
                    'otp_code' => $code,
                    'expires_at' => now()->addMinutes(5),
                    'is_verified' => false,
                ]
            );

            logger()->info("OTP for {$mobileNumber}: {$code}");
        }

        $this->verifyForm->mobileNumber = $mobileNumber;
        $this->otpSent = true;

        Notification::make()
            ->title('Check your phone')
            ->body('If this number is registered, you will receive a verification code shortly.')
            ->success()
            ->send();
    }

    public function verifyOtp(): void
    {
        $this->verifyForm->validate();

        $otp = OtpVerification::query()
            ->valid()
            ->where('mobile_number', $this->verifyForm->mobileNumber)
            ->where('otp_code', $this->verifyForm->otpCode)
            ->first();

        $user = $otp
            ? User::query()->where('mobile_number', $this->verifyForm->mobileNumber)->where('role', 'admin')->first()
            : null;

        if (! $otp || ! $user) {
            throw ValidationException::withMessages([
                'verifyForm.otpCode' => 'Invalid or expired OTP.',
            ]);
        }

        $otp->update(['is_verified' => true]);

        Filament::auth()->login($user);
        session()->regenerate();

        redirect()->intended(Filament::getUrl());
    }
}