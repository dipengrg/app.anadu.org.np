<?php

namespace App\Filament\Widgets;

use App\Models\Contribution;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContributionsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalAmount = Contribution::query()->sum('amount');
        $totalCount = Contribution::query()->count();

        $thisMonthAmount = Contribution::query()
            ->where('received_on', '>=', now()->startOfMonth()->toDateString())
            ->sum('amount');

        $totalPoints = Contribution::query()
            ->join('contribution_tiers', 'contributions.contribution_tier_id', '=', 'contribution_tiers.id')
            ->sum('contribution_tiers.points');

        return [
            Stat::make('Total Contributions', number_format((float) $totalAmount, 2))
                ->description($totalCount.' contributions recorded')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('This Month', number_format((float) $thisMonthAmount, 2))
                ->description('Received since '.now()->startOfMonth()->format('M j'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),

            Stat::make('Total Tier Points', number_format((float) $totalPoints))
                ->description('Cumulative points across all contributions')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
        ];
    }
}