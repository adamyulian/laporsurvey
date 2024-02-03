<?php

namespace App\Filament\Resources\SurveykendaraanResource\Pages;

use App\Filament\Resources\SurveykendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSurveykendaraan extends ViewRecord
{
    protected static string $resource = SurveykendaraanResource::class;

    protected ?string $heading = 'Hasil Survey';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
