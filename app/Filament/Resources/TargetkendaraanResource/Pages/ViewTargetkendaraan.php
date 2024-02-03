<?php

namespace App\Filament\Resources\TargetkendaraanResource\Pages;

use App\Filament\Resources\TargetkendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTargetkendaraan extends ViewRecord
{
    protected static string $resource = TargetkendaraanResource::class;

    protected ?string $heading = 'View Target';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
