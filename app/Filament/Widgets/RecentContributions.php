<?php

namespace App\Filament\Widgets;

use App\Models\Contribution;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentContributions extends BaseWidget
{
    protected static ?string $heading = 'Recent Contributions';

    protected int|string|array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Contribution::query()
                    ->with(['profile', 'category', 'tier'])
                    ->latest('received_on')
            )
            ->columns([
                TextColumn::make('contributor')
                    ->label('Contributor')
                    ->state(fn (Contribution $record): string => $record->profile?->name
                        ?? $record->external_donor_name
                        ?? 'Unknown'),
                TextColumn::make('category.title')
                    ->label('Category')
                    ->badge(),
                TextColumn::make('tier.title')
                    ->label('Tier'),
                TextColumn::make('amount')
                    ->money('NPR')
                    ->sortable(),
                TextColumn::make('received_on')
                    ->date()
                    ->sortable(),
            ])
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}