<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CommunityStatsOverview;
use App\Filament\Widgets\ContributionsByTierChart;
use App\Filament\Widgets\ContributionsOverview;
use App\Filament\Widgets\RecentContributions;
use App\Filament\Widgets\UpcomingEvents;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    /**
     * Explicit widget list + order, instead of relying on
     * Filament::getWidgets() (every auto-discovered widget in
     * app/Filament/Widgets). This keeps the dashboard curated even
     * if unrelated widgets get added to the Widgets folder later.
     */
    public function getWidgets(): array
    {
        return [
            CommunityStatsOverview::class,
            ContributionsOverview::class,
            UpcomingEvents::class,
            ContributionsByTierChart::class,
            RecentContributions::class,
        ];
    }

    public function getColumns(): int|array
    {
        return [
            'md' => 2,
            'xl' => 3,
        ];
    }
}