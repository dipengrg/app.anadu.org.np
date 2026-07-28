<?php

namespace App\Filament\Resources\ParticipationTiers;

use App\Filament\Resources\Concerns\RestrictedToAdmins;
use App\Filament\Resources\ParticipationTiers\Pages\ManageParticipationTiers;
use App\Models\ParticipationTier;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ParticipationTierResource extends Resource
{
    use RestrictedToAdmins;
    
    protected static ?string $model = ParticipationTier::class;

    protected static string | UnitEnum | null $navigationGroup = 'Platform Settings';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationLabel = 'Participation Tiers';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('summary')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('points')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('points')
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
            'index' => ManageParticipationTiers::route('/'),
        ];
    }
}
