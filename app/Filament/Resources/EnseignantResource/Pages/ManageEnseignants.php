<?php

namespace App\Filament\Resources\EnseignantResource\Pages;

use App\Filament\Resources\EnseignantResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEnseignants extends ManageRecords
{
    protected static string $resource = EnseignantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
