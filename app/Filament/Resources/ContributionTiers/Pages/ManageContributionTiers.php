<?php

namespace App\Filament\Resources\ContributionTiers\Pages;

use App\Filament\Resources\ContributionTiers\ContributionTierResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageContributionTiers extends ManageRecords
{
    protected static string $resource = ContributionTierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
