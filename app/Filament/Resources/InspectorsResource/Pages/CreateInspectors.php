<?php

namespace App\Filament\Resources\UserDetailsResource\Pages;

use App\Filament\Resources\InspectorsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInspectors extends CreateRecord
{
    protected static string $resource = InspectorsResource::class;
}
