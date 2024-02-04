<?php

namespace App\Filament\Resources\Target2Resource\Pages;

use App\Filament\Resources\Target2Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTarget2 extends EditRecord
{
    protected static string $resource = Target2Resource::class;

    protected ?string $heading = 'Edit Target';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
