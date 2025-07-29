<?php

namespace App\Filament\Resources\CrownBlock\MainResource\Pages;

use App\Filament\Resources\CrownBlock\MainResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMains extends ListRecords
{
    protected static string $resource = MainResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
