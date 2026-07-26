<?php

namespace App\Filament\Resources\Contributions;

use App\Filament\Resources\Contributions\Pages\ManageContributions;
use App\Models\Contribution;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContributionResource extends Resource
{
    protected static ?string $model = Contribution::class;

    protected static string | UnitEnum | null $navigationGroup = 'Contributions';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Contributions Management';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('profile_id')
                    ->relationship('profile', 'name'),
                TextInput::make('contribution_category_id')
                    ->required()
                    ->numeric(),
                TextInput::make('contribution_tier_id')
                    ->required()
                    ->numeric(),
                TextInput::make('external_donor_name'),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Textarea::make('summary')
                    ->columnSpanFull(),
                DatePicker::make('received_on')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('profile.name')
                    ->searchable(),
                TextColumn::make('contribution_category_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('contribution_tier_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('external_donor_name')
                    ->searchable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('received_on')
                    ->date()
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
            'index' => ManageContributions::route('/'),
        ];
    }
}
