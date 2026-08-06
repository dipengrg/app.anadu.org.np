<?php

namespace App\Filament\Resources\MotherGroups;

use App\Filament\Resources\MotherGroups\Pages\ManageMotherGroups;
use App\Models\MotherGroup;
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

class MotherGroupResource extends Resource
{
    protected static ?string $model = MotherGroup::class;

    protected static string | UnitEnum | null $navigationGroup = 'People & Membership';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Mother Groups';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('profile_id')
                    ->relationship('profile', 'name', fn ($query) => $query->where('gender', 'female'))
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('designation')
                    ->required(),
                TextInput::make('rank')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('profile.name')
                    ->searchable(),
                TextColumn::make('designation')
                    ->searchable(),
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
            'index' => ManageMotherGroups::route('/'),
        ];
    }
}
