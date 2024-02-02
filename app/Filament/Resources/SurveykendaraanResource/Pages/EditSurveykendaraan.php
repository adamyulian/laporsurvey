<?php

namespace App\Filament\Resources\SurveykendaraanResource\Pages;

use App\Filament\Resources\SurveykendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSurveykendaraan extends EditRecord
{
    protected static string $resource = SurveykendaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
