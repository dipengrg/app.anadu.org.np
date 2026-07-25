<?php

use App\Filament\Pages\ProfileSettings;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->post('/profile-settings', [ProfileSettings::class, 'submit'])->name('profile-settings.update');
