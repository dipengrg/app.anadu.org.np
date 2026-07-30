<?php

namespace App\Filament\Resources\Members\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DependentsRelationManager extends RelationManager
{
    protected static string $relationship = 'dependents';

    protected static ?string $title = 'Dependents';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('profile_id')
                    ->label('Dependent')
                    ->relationship(
                        name: 'profile',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query
                            ->where('id', '!=', $this->getOwnerRecord()->profile_id),
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->unique(
                        table: 'member_dependents',
                        column: 'profile_id',
                        ignoreRecord: true,
                        modifyRuleUsing: fn ($rule) => $rule->where('member_id', $this->getOwnerRecord()->id),
                    )
                    ->validationMessages([
                        'unique' => 'This profile is already listed as a dependent of this member.',
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('profile.name')
            ->columns([
                TextColumn::make('profile.name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('profile.gender')
                    ->badge(),
                TextColumn::make('profile.dob')
                    ->label('Date of birth')
                    ->date(),
                TextColumn::make('created_at')
                    ->label('Added on')
                    ->dateTime()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}