<?php

namespace App\Filament\Resources\Contributions\Pages;

use App\Filament\Resources\Contributions\ContributionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageContributions extends ManageRecords
{
    protected static string $resource = ContributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
