<?php

namespace App\Filament\Resources\Profiles;

use App\Filament\Resources\Profiles\Pages\ManageProfiles;
use App\Models\Profile;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
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
use Filament\Tables\Table;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static string | UnitEnum | null $navigationGroup = 'People & Membership';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Profile Management';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->helperText('Mr., Mrs., Ms. or Rank.'),
                TextInput::make('name')
                    ->required(),
                Select::make('gender')
                    ->options(['male' => 'Male', 'female' => 'Female'])
                    ->required(),
                Select::make('zodiac_id')
                    ->relationship('zodiac', 'title')
                    ->required(),
                DatePicker::make('dob')
                    ->maxDate(now()),
                Select::make('marital_status')
                    ->options(['single' => 'Single', 'married' => 'Married'])
                    ->default('single')
                    ->required(),
                Section::make('photo')
                    ->schema([
                        FileUpload::make('photo')
                            ->image()
                            ->avatar()
                            ->directory('profile-photos')
                            ->visibility('public'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('photo')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=Member&background=random'),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('gender')
                    ->badge(),
                TextColumn::make('marital_status')
                    ->badge(),
                TextColumn::make('dob')
                    ->date()
                    ->sortable(),
                TextColumn::make('zodiac.title')
                    ->label('Zodiac')
                    ->badge()
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
            'index' => ManageProfiles::route('/'),
        ];
    }
}
