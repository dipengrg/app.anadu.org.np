<?php

namespace App\Filament\Resources\MotherGroups\Pages;

use App\Filament\Resources\MotherGroups\MotherGroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMotherGroups extends ManageRecords
{
    protected static string $resource = MotherGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
