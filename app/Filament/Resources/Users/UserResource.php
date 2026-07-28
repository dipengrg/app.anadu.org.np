<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Concerns\RestrictedToAdmins;
use App\Filament\Resources\Users\Pages\ManageUsers;
use App\Models\User;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    use RestrictedToAdmins;
    
    protected static ?string $model = User::class;

    protected static string | UnitEnum | null $navigationGroup = 'Platform Settings';
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationLabel = 'Moderator Management';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('role')
                    ->default('moderator'),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->autocomplete('new-password')
                    ->maxLength(255)
                    ->helperText(fn (string $context): ?string => $context === 'edit' ? 'Leave blank to keep the current password.' : null),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('role', 'moderator'))
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean()
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageUsers::route('/'),
        ];
    }
}
