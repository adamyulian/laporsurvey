<?php

namespace App\Filament\Exports;

use App\Models\Target2;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class Target2Exporter extends Exporter
{
    protected static ?string $model = Target2::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('nopol'),
            ExportColumn::make('tahun'),
            ExportColumn::make('merk'),
            ExportColumn::make('tipe'),
            ExportColumn::make('jabatan'),
            ExportColumn::make('opd'),
            ExportColumn::make('nama_penyelia'),
            ExportColumn::make('status'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your target2 export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
