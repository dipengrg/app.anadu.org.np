<?php

namespace App\Filament\Pages;

use App\Models\User;
use UnitEnum;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordSettings extends Page implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    protected static string | UnitEnum | null $navigationGroup = 'My Account';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Password Settings';

    public ?array $passwordData = [];

    public function mount(): void
    {
        abort_unless(auth()->check(), 403);

        $this->passwordForm->fill();
    }

    public function passwordForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('current_password')
                    ->label('Current password')
                    ->password()
                    ->revealable()
                    ->required()
                    ->autocomplete('current-password'),
                TextInput::make('password')
                    ->label('New password')
                    ->password()
                    ->revealable()
                    ->required()
                    ->minLength(5)
                    ->confirmed()
                    ->autocomplete('new-password'),
                TextInput::make('password_confirmation')
                    ->label('Confirm new password')
                    ->password()
                    ->revealable()
                    ->required()
                    ->autocomplete('new-password'),
            ])
            ->statePath('passwordData');
    }

    /**
     * Builds the page body directly — replaces the old
     * resources/views/filament/pages/password-settings.blade.php file.
     */
    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('passwordForm')])
                    ->id('passwordForm')
                    ->livewireSubmitHandler('updatePassword')
                    ->footer([
                        Actions::make([
                            Action::make('savePassword')
                                ->label('Update Password')
                                ->submit('updatePassword'),
                        ]),
                    ]),
            ]);
    }

    public function updatePassword(): void
    {
        $data = $this->passwordForm->getState();

        /** @var User $user */
        $user = auth()->user();

        if (! Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'passwordData.current_password' => 'The current password is incorrect.',
            ]);
        }

        $user->forceFill([
            'password' => Hash::make($data['password']),
        ])->save();

        $this->passwordForm->fill();

        Notification::make()
            ->title('Password updated')
            ->success()
            ->send();
    }
}