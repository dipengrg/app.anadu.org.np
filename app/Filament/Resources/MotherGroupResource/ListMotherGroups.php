<?php

namespace App\Filament\Resources\MotherGroupResource\Pages;

use App\Filament\Resources\MotherGroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMotherGroups extends ListRecords
{
    // Every Page class points back to the Resource that owns its
    // form()/table() definitions.
    protected static string $resource = MotherGroupResource::class;

    // Header button shown top-right of the list page.
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}