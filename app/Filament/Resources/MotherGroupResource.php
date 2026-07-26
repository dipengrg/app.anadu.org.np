<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MotherGroupResource\Pages;
use App\Models\MotherGroup;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MotherGroupResource extends Resource
{
    // Tells Filament which Eloquent model this resource manages.
    protected static ?string $model = MotherGroup::class;

    // Sidebar icon (heroicons).
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user-group';

    // Sidebar label + labels used in page titles, buttons, notifications.
    protected static ?string $navigationLabel = "Mothers' Group";

    protected static ?string $modelLabel = "mothers' group member";

    protected static ?string $pluralModelLabel = "mothers' group";

    // URL segment: /admin/mothers-group
    protected static ?string $slug = 'mothers-group';

    /**
     * form() defines every field shown on the Create and Edit pages.
     * Filament reuses the SAME schema for both — no duplication needed.
     */
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                // 1. Plain text input, maps straight to the `designation` column.
                TextInput::make('designation')
                    ->required()
                    ->maxLength(255),

                // 2. Fixed dropdown — NOT numeric(), because rank is a closed
                // set of values (0-5), not an arbitrary number.
                Select::make('rank')
                    ->options([
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5',
                    ])
                    ->required()
                    ->helperText('Used to order the hierarchy on client apps. 0 is highest.'),

                // 3. Relationship select. `profile_id` is stored on this table,
                // but the *option list* comes from the related Profile model
                // via the profile() belongsTo() method.
                Select::make('profile_id')
                    ->label('Profile')
                    ->relationship(
                        name: 'profile',
                        titleAttribute: 'name',
                        // Restrict which profiles are selectable:
                        // only women, and only those not already assigned
                        // to a mother's group row (profile_id is unique).
                        // $record is the current MotherGroup row when editing,
                        // null when creating — used to still show the
                        // currently-assigned profile on the edit screen.
                        modifyQueryUsing: fn ($query, $record) => $query
                            ->where('gender', 'female')
                            ->where(function ($query) use ($record) {
                                $query->whereDoesntHave('motherGroup')
                                    ->when($record, fn ($query) => $query->orWhereKey($record->profile_id));
                            }),
                    )
                    ->searchable()   // live search instead of a giant dropdown
                    ->preload()      // load first options immediately on open
                    ->required()
                    // Extra safety net: gives a clean inline validation message
                    // instead of a raw SQL "unique constraint" error if two
                    // admins try to assign the same profile at once.
                    ->unique(ignoreRecord: true)
                    ->helperText('Search by name. Only female profiles not already in the group are listed.'),
            ]);
    }

    /**
     * table() defines the list page: columns, filters, row actions.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rank')
                    ->badge()
                    ->sortable(),
                TextColumn::make('designation')
                    ->searchable()
                    ->sortable(),
                // Dot notation reaches through the relationship:
                // profile.name means "join profile, show its name column".
                TextColumn::make('profile.name')
                    ->label('Profile')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('profile.clan.title')
                    ->label('Clan')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('rank')
            ->filters([
                SelectFilter::make('rank')
                    ->options([
                        0 => '0', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5',
                    ]),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([]);
    }

    /**
     * getPages() maps URLs to the Page classes. Auto-generated by
     * make:filament-resource — you almost never need to edit this.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMotherGroups::route('/'),
            'create' => Pages\CreateMotherGroup::route('/create'),
            'edit' => Pages\EditMotherGroup::route('/{record}/edit'),
        ];
    }
}