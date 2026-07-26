<?php

namespace App\Filament\Resources\ParticipationTiers\Pages;

use App\Filament\Resources\ParticipationTiers\ParticipationTierResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageParticipationTiers extends ManageRecords
{
    protected static string $resource = ParticipationTierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
