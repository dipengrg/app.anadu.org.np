<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Models\Clan;
use App\Models\Profile;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'Profiles';

    protected static ?string $modelLabel = 'profile';

    protected static ?string $pluralModelLabel = 'profiles';

    protected static ?string $slug = 'profiles';

    public const ANCESTRAL_ADDRESSES = [
        'kodi' => 'Kodi',
        'manikharka' => 'Manikharka',
        'mulbari' => 'Mulbari',
        'saudara' => 'Saudara',
        'andara' => 'Andara',
    ];

    public const RESIDENCE_TYPES = [
        'local' => 'Local',
        'city' => 'City',
        'abroad' => 'Abroad',
    ];

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Photo')
                    ->schema([
                        FileUpload::make('photo')
                            ->image()
                            ->avatar()
                            ->directory('profile-photos')
                            ->visibility('public'),
                    ])
                    ->columnSpan(1),

                Section::make('Personal details')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->maxLength(255)
                            ->helperText('Optional honorific, e.g. Mr., Mrs., Dr.'),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                            ])
                            ->required(),
                        DatePicker::make('dob')
                            ->label('Date of birth')
                            ->maxDate(now())
                            ->displayFormat('d M Y'),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        Select::make('clan_id')
                            ->label('Clan')
                            ->relationship('clan', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('ancestral_address')
                            ->options(self::ANCESTRAL_ADDRESSES)
                            ->required(),
                        Select::make('residence_type')
                            ->options(self::RESIDENCE_TYPES)
                            ->required(),
                    ]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=Member&background=random'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('clan.title')
                    ->label('Clan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gender')
                    ->badge()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('residence_type')
                    ->label('Residence')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => self::RESIDENCE_TYPES[$state] ?? $state)
                    ->sortable(),
                TextColumn::make('ancestral_address')
                    ->label('Ancestral address')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => self::ANCESTRAL_ADDRESSES[$state] ?? $state)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('dob')
                    ->label('Date of birth')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->filters([
                SelectFilter::make('clan_id')
                    ->label('Clan')
                    ->options(fn () => Clan::query()->pluck('title', 'id')),
                SelectFilter::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ]),
                SelectFilter::make('residence_type')
                    ->label('Residence')
                    ->options(self::RESIDENCE_TYPES),
                SelectFilter::make('ancestral_address')
                    ->label('Ancestral address')
                    ->options(self::ANCESTRAL_ADDRESSES),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }
}