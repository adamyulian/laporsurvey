<?php

namespace App\Filament\Resources\DetailResource\Pages;

use App\Filament\Resources\DetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDetails extends ListRecords
{
    protected static string $resource = DetailResource::class;

    protected static ?string $recordTitleAttribute = 'Detail Penggunaan';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
