<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class UpcomingEvents extends BaseWidget
{
    protected static ?string $heading = 'Upcoming Events';

    protected int|string|array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Event::query()
                    ->with('category')
                    ->where('scheduled_on', '>=', now()->toDateString())
                    ->orderBy('scheduled_on')
            )
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('category.title')
                    ->label('Category')
                    ->badge(),
                TextColumn::make('scheduled_on')
                    ->label('Date')
                    ->date()
                    ->sortable(),
            ])
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}