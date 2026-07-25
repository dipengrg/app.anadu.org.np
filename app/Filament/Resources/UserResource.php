<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use BackedEnum;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Moderators';

    protected static ?string $modelLabel = 'moderator';

    protected static ?string $pluralModelLabel = 'moderators';

    protected static ?string $slug = 'moderators';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                Checkbox::make('is_active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('role', 'moderator'))
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                Filter::make('active')
                    ->query(fn ($query) => $query->where('is_active', true)),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([]);
    }

    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()?->role === 'admin';
    }

    public static function canCreate(): bool
    {
        return Auth::check() && Auth::user()?->role === 'admin';
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::check() && Auth::user()?->role === 'admin' && $record->role === 'moderator';
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::check() && Auth::user()?->role === 'admin' && $record->role === 'moderator';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
