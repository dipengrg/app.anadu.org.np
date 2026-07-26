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
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileSettings extends Page implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    protected static string | UnitEnum | null $navigationGroup = 'My Account';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Profile Settings';

    public ?array $profileData = [];

    public function mount(): void
    {
        abort_unless(auth()->check(), 403);

        $user = auth()->user();

        $this->profileForm->fill([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function profileForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->maxLength(255),
            ])
            ->statePath('profileData');
    }

    /**
     * Builds the page body directly — replaces the old
     * resources/views/filament/pages/profile-settings.blade.php file.
     */
    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('profileForm')])
                    ->id('profileForm')
                    ->livewireSubmitHandler('updateProfile')
                    ->footer([
                        Actions::make([
                            Action::make('saveProfile')
                                ->label('Save Profile')
                                ->submit('updateProfile'),
                        ]),
                    ]),
            ]);
    }

    public function updateProfile(): void
    {
        $data = $this->profileForm->getState();

        /** @var User $user */
        $user = auth()->user();

        $validated = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
        ])->validate();

        $user->forceFill($validated)->save();

        Notification::make()
            ->title('Profile updated')
            ->success()
            ->send();
    }
}