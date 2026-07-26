<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\ManageEvents;
use App\Models\Event;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static string | UnitEnum | null $navigationGroup = 'Events';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Events Management';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('event_category_id')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('summary')
                    ->columnSpanFull(),
                DatePicker::make('scheduled_on')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('event_category_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('scheduled_on')
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
            'index' => ManageEvents::route('/'),
        ];
    }
}
