<?php

namespace App\Filament\Resources\Target2Resource\Pages;

use App\Filament\Resources\Target2Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTarget2s extends ListRecords
{
    protected static string $resource = Target2Resource::class;

    protected ?string $heading = 'List Target';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
