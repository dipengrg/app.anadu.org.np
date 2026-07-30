<?php

namespace App\Filament\Resources\Committees;

use App\Filament\Resources\Committees\Pages\ManageCommittees;
use App\Models\Committee;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CommitteeResource extends Resource
{
    protected static ?string $model = Committee::class;

    protected static string | UnitEnum | null $navigationGroup = 'People & Membership';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Committee Management';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Committee Details')
                    ->columns(2)
                    ->schema([
                        Select::make('profile_id')
                            ->relationship('profile', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('rank')
                            ->numeric()
                            ->required(),
                        TextInput::make('designation')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                    ]),
                Section::make('Tenure')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('started_on')
                            ->required(),
                        DatePicker::make('ended_on')
                            ->after('started_on'),
                        TextInput::make('end_reason')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('designation')
                    ->searchable(),
                TextColumn::make('profile.name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('phone')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('started_on')
                    ->date()
                    ->sortable(),
                TextColumn::make('ended_on')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ManageCommittees::route('/'),
        ];
    }
}
