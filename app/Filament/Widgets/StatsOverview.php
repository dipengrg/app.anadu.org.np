<?php

namespace App\Filament\Widgets;

use App\Models\CommitteeMember;
use App\Models\Contribution;
use App\Models\Event;
use App\Models\Profile;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Members', Profile::query()->count())
                ->description('Registered community profiles')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Committee Members', CommitteeMember::query()->count())
                ->description('Active committee roles')
                ->descriptionIcon('heroicon-m-identification')
                ->color('info'),

            Stat::make('Upcoming Events', Event::query()
                ->where('scheduled_on', '>=', now()->toDateString())
                ->count())
                ->description('Scheduled from today')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),

            Stat::make('Total Contributions', number_format(Contribution::query()->sum('amount'), 2))
                ->description(Contribution::query()->count().' contributions recorded')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
        ];
    }
}
