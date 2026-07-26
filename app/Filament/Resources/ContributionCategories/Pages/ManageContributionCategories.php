<?php

namespace App\Filament\Resources\ContributionCategories\Pages;

use App\Filament\Resources\ContributionCategories\ContributionCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageContributionCategories extends ManageRecords
{
    protected static string $resource = ContributionCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
