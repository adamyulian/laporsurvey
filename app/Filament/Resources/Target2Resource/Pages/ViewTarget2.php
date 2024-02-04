<?php

namespace App\Filament\Resources\Target2Resource\Pages;

use App\Filament\Resources\Target2Resource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTarget2 extends ViewRecord
{
    protected static string $resource = Target2Resource::class;

    protected ?string $heading = 'View Target';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
