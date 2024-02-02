<?php

namespace App\Filament\Resources\TargetkendaraanResource\Pages;

use App\Filament\Resources\TargetkendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTargetkendaraan extends EditRecord
{
    protected static string $resource = TargetkendaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
