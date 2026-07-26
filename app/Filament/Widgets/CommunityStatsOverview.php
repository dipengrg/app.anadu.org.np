<?php

namespace App\Filament\Widgets;

use App\Models\Clan;
use App\Models\CommitteeMember;
use App\Models\Profile;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CommunityStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Members', Profile::query()->count())
                ->description('Registered community profiles')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Total Clans', Clan::query()->count())
                ->description('Registered clan groups')
                ->descriptionIcon('heroicon-m-rectangle-group')
                ->color('info'),

            Stat::make('Committee Members', CommitteeMember::query()
                ->where(function ($query) {
                    $query->whereNull('ended_on')
                        ->orWhere('ended_on', '>=', now()->toDateString());
                })
                ->count())
                ->description('Currently active roles')
                ->descriptionIcon('heroicon-m-identification')
                ->color('warning'),

            Stat::make('New Members', Profile::query()
                ->where('created_at', '>=', now()->startOfMonth())
                ->count())
                ->description('Added this month')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('primary'),
        ];
    }
}