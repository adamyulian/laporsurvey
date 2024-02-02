<?php

namespace App\Filament\Resources\SurveykendaraanResource\Pages;

use App\Filament\Resources\SurveykendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSurveykendaraans extends ListRecords
{
    protected static string $resource = SurveykendaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
