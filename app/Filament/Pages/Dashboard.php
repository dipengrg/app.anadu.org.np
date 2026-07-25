<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Pages\Page;

class Dashboard extends Page
{
    // protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Dashboard';

    protected string $view = 'filament.pages.dashboard';

    public function getUser(): User
    {
        return Filament::auth()->user();
    }

    public function getLogoutUrl(): string
    {
        return Filament::getLogoutUrl();
    }
}