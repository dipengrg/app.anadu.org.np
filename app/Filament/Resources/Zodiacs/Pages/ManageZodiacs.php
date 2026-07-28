<?php

namespace App\Filament\Resources\Zodiacs\Pages;

use App\Filament\Resources\Zodiacs\ZodiacResource;
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
