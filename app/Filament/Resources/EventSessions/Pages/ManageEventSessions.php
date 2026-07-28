<?php

namespace App\Filament\Resources\EventSessions\Pages;

use App\Filament\Resources\EventSessions\EventSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageEventSessions extends ManageRecords
{
    protected static string $resource = EventSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
