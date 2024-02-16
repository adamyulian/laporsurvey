<?php

namespace App\Filament\Resources\DetailResource\Pages;

use App\Filament\Resources\DetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDetail extends ViewRecord
{
    protected static string $resource = DetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
