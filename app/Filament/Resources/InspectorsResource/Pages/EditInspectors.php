<?php

namespace App\Filament\Resources\UserDetailsResource\Pages;

use App\Filament\Resources\InspectorsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInspectors extends EditRecord
{
    protected static string $resource = InspectorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
