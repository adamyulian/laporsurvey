<?php

namespace App\Filament\Resources\TargetkendaraanResource\Pages;

use App\Filament\Resources\TargetkendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTargetkendaraan extends CreateRecord
{
    protected static string $resource = TargetkendaraanResource::class;

    protected ?string $heading = 'Create Target';
}
