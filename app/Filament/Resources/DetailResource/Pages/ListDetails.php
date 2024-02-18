<?php

namespace App\Filament\Resources\DetailResource\Pages;

use App\Filament\Resources\DetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDetails extends ListRecords
{
    protected static string $resource = DetailResource::class;

    public static function canView(): bool
        {
            return auth()->user()->role === 'admin';
        }

    protected ?string $heading = 'Detail Penggunaan';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
