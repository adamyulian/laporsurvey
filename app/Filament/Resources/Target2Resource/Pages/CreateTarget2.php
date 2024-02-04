<?php

namespace App\Filament\Resources\Target2Resource\Pages;

use App\Filament\Resources\Target2Resource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTarget2 extends CreateRecord
{
    protected static string $resource = Target2Resource::class;

    protected ?string $heading = 'Create Target';
}
