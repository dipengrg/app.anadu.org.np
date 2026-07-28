<?php

namespace App\Filament\Resources\Zodiac\Pages;

use App\Filament\Resources\Clans\ZodiacResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageZodiacs extends ManageRecords
{
    protected static string $resource = ZodiacResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
