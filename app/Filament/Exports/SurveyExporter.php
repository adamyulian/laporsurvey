<?php

namespace App\Filament\Exports;

use App\Models\Survey;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class SurveyExporter extends Exporter
{
    protected static ?string $model = Survey::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('target.nama'),
            ExportColumn::make('target.register'),
            ExportColumn::make('target.luas'),
            ExportColumn::make('target.tahun_perolehan'),
            ExportColumn::make('status'),
            ExportColumn::make('guna'),
            ExportColumn::make('nama_pic'),
            ExportColumn::make('no_hp_pic'),
            ExportColumn::make('hubungan_hukum'),
            ExportColumn::make('detail'),
            ExportColumn::make('lat'),
            ExportColumn::make('lng'),
            ExportColumn::make('address'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your survey export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
