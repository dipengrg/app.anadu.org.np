<?php

namespace App\Filament\Widgets;

use App\Models\ContributionTier;
use Filament\Widgets\ChartWidget;

class ContributionsByTierChart extends ChartWidget
{
    protected ?string $heading = 'Contributions by Tier';

    protected int|string|array $columnSpan = 1;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $tiers = ContributionTier::query()
            ->withCount('contributions')
            ->orderByDesc('contributions_count')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Contributions',
                    'data' => $tiers->pluck('contributions_count')->all(),
                    'backgroundColor' => [
                        '#f59e0b', '#3b82f6', '#10b981', '#8b5cf6', '#ef4444', '#14b8a6',
                    ],
                ],
            ],
            'labels' => $tiers->pluck('title')->all(),
        ];
    }
}