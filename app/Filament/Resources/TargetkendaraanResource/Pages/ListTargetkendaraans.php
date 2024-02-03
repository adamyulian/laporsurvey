<?php

namespace App\Filament\Resources\TargetkendaraanResource\Pages;

use App\Filament\Resources\TargetkendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTargetkendaraans extends ListRecords
{
    protected static string $resource = TargetkendaraanResource::class;

    protected ?string $heading = 'List Target';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
