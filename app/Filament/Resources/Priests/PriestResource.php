<?php

namespace App\Filament\Resources\Priests;

use App\Filament\Resources\Priests\Pages\ManagePriests;
use App\Models\Priest;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PriestResource extends Resource
{
    protected static ?string $model = Priest::class;

    protected static string | UnitEnum | null $navigationGroup = 'People & Membership';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Priest Management';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('profile_id')
                    ->relationship('profile', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('Each profile can only be linked to one priest record.'),
                Select::make('type')
                    ->options([
                        'pachyu' => 'Pachyu',
                        'klehpri' => 'Klehpri',
                    ])
                    ->required(),
                TextInput::make('rank')
                    ->required()
                    ->numeric()
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('profile.name')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pachyu' => 'Pachyu',
                        'klehpri' => 'Klehpri',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pachyu' => 'warning',
                        'klehpri' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('rank')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ManagePriests::route('/'),
        ];
    }
}