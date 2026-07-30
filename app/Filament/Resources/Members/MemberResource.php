<?php

namespace App\Filament\Resources\Members;

use App\Filament\Resources\Members\Pages\CreateMember;
use App\Filament\Resources\Members\Pages\EditMember;
use App\Filament\Resources\Members\Pages\ListMembers;
use App\Filament\Resources\Members\RelationManagers\DependentsRelationManager;
use App\Models\Member;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static string | UnitEnum | null $navigationGroup = 'People & Membership';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Member Management';

    protected static ?string $recordTitleAttribute = 'mid';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Membership')
                    ->columns(2)
                    ->schema([
                        Select::make('profile_id')
                            ->relationship('profile', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('clan_id')
                            ->relationship('clan', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('mid')
                            ->label('Member ID')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(4)
                            ->formatStateUsing(fn (?string $state): ?string => $state ? strtoupper($state) : $state)
                            ->dehydrateStateUsing(fn (?string $state): ?string => $state ? strtoupper($state) : $state)
                            ->regex('/^(KD|MK|MB|SD|AN)(0[1-9]|[1-9][0-9])$/')
                            ->validationMessages([
                                'regex' => 'Format must be a 2-letter place prefix (KD, MK, MB, SD or AN) followed by a 2-digit number 01-99, e.g. KD55.',
                            ])
                            ->helperText('Prefix: KD = Kodi, MK = Manikharka, MB = Mulbari, SD = Saudara, AN = Andara. Suffix: 01-99.')
                            ->rule(function (Get $get) {
                                return function (string $attribute, $value, \Closure $fail) use ($get) {
                                    $prefixMap = [
                                        'kodi' => 'KD',
                                        'manikharka' => 'MK',
                                        'mulbari' => 'MB',
                                        'saudara' => 'SD',
                                        'andara' => 'AN',
                                    ];

                                    $ancestralAddress = $get('ancestral_address');

                                    if (! $ancestralAddress || ! isset($prefixMap[$ancestralAddress])) {
                                        return;
                                    }

                                    $expectedPrefix = $prefixMap[$ancestralAddress];

                                    if (! str_starts_with((string) $value, $expectedPrefix)) {
                                        $fail("Member ID prefix should be {$expectedPrefix} to match the selected ancestral address ({$ancestralAddress}).");
                                    }
                                };
                            }),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('designation')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('rank')
                            ->numeric()
                            ->required(),
                        Select::make('role')
                            ->options([
                                'executive' => 'Executive',
                                'general' => 'General',
                            ])
                            ->required(),
                        Select::make('ancestral_address')
                            ->options([
                                'kodi' => 'Kodi',
                                'manikharka' => 'Manikharka',
                                'mulbari' => 'Mulbari',
                                'saudara' => 'Saudara',
                                'andara' => 'Andara',
                            ])
                            ->required(),
                        Select::make('residence_type')
                            ->options([
                                'local' => 'Local',
                                'city' => 'City',
                                'abroad' => 'Abroad',
                            ])
                            ->required(),
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
            ->recordTitleAttribute('mid')
            ->columns([
                TextColumn::make('mid')
                    ->label('Member ID')
                    ->searchable(),
                TextColumn::make('profile.name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('clan.title')
                    ->label('Clan')
                    ->badge()
                    ->sortable(),
                TextColumn::make('designation')
                    ->searchable(),
                TextColumn::make('role')
                    ->badge()
                    ->sortable(),
                TextColumn::make('ancestral_address')
                    ->badge()
                    ->sortable(),
                TextColumn::make('residence_type')
                    ->badge()
                    ->sortable(),
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
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'executive' => 'Executive',
                        'general' => 'General',
                    ]),
                SelectFilter::make('residence_type')
                    ->options([
                        'local' => 'Local',
                        'city' => 'City',
                        'abroad' => 'Abroad',
                    ]),
                SelectFilter::make('clan_id')
                    ->relationship('clan', 'title')
                    ->label('Clan'),
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

    public static function getRelations(): array
    {
        return [
            DependentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMembers::route('/'),
            'create' => CreateMember::route('/create'),
            'edit' => EditMember::route('/{record}/edit'),
        ];
    }
}