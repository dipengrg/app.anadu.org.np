<?php

namespace App\Filament\Resources\Concerns;

use Illuminate\Support\Facades\Auth;

trait RestrictedToAdmins
{
    public static function canAccess(): bool
    {
        return Auth::user()?->role === 'admin';
    }
}