<x-filament-panels::page.simple>
    @if (! $otpSent)
        <form wire:submit="sendOtp" class="space-y-6">
            <div>
                <x-filament::input.wrapper>
                    <x-filament::input
                        type="tel"
                        wire:model="sendForm.mobileNumber"
                        placeholder="Mobile number"
                        autofocus
                    />
                </x-filament::input.wrapper>
                @error('sendForm.mobileNumber')
                    <p class="text-sm text-danger-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <x-filament::button type="submit" class="w-full">
                Send OTP
            </x-filament::button>
        </form>
    @else
        <form wire:submit="verifyOtp" class="space-y-6">
            <div>
                <x-filament::input.wrapper>
                    <x-filament::input
                        type="text"
                        wire:model="verifyForm.otpCode"
                        placeholder="Enter OTP"
                        autofocus
                    />
                </x-filament::input.wrapper>
                @error('verifyForm.otpCode')
                    <p class="text-sm text-danger-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <x-filament::button type="submit" class="w-full">
                Verify &amp; Login
            </x-filament::button>
        </form>
    @endif
</x-filament-panels::page.simple>