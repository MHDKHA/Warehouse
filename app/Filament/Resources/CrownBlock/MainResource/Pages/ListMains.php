<?php

namespace App\Filament\Resources\CrownBlock\MainResource\Pages;

use App\Filament\Resources\CrownBlock\MainResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMains extends ListRecords
{
    protected static string $resource = MainResource::class;

    public ?int $wo_id = null;

    public function mount(): void
    {
        parent::mount();

        $this->wo_id = (int) request()->route('wo_id');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Certification')
                ->url(fn () => MainResource::getUrl('create', ['wo_id' => $this->wo_id])),
        ];
    }

    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        if ($this->wo_id) {
            $query->where('wo_id', $this->wo_id);
        }

        return $query;
    }
}
