<?php

namespace App\Filament\Pages;

use App\Models\User;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileSettings extends Page
{
    protected static ?string $navigationLabel = 'Profile Settings';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-circle';

    protected string $view = 'filament.pages.profile-settings';

    public function mount(): void
    {
        abort_unless(auth()->check(), 403);
    }

    public function submit(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if (! $user instanceof User) {
            abort(403);
        }

        if ($request->input('action') === 'password') {
            $data = $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', 'min:5'],
            ]);

            $user->forceFill([
                'password' => Hash::make($data['password']),
            ])->save();

            Notification::make()
                ->title('Password updated')
                ->success()
                ->send();

            return redirect()->back()->with('success', 'Password updated successfully.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $user->forceFill([
            'name' => $data['name'],
            'email' => $data['email'],
        ])->save();

        Notification::make()
            ->title('Profile updated')
            ->success()
            ->send();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
