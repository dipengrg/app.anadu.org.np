<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class VerifyOtpForm extends Form
{
    #[Validate('required|string')]
    public string $mobileNumber = '';

    #[Validate('required|string')]
    public string $otpCode = '';
}