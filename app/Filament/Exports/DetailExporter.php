<?php

namespace App\Filament\Exports;

use App\Models\Detail;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class DetailExporter extends Exporter
{
    protected static ?string $model = Detail::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('survey.target.register'),
            ExportColumn::make('id_penggunaan'),
            ExportColumn::make('penggunaan'),
            ExportColumn::make('luas'),
            ExportColumn::make('detail'),
            ExportColumn::make('kondisi'),
            ExportColumn::make('foto_penggunaan'),
            ExportColumn::make('hub_hukum'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your detail export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
