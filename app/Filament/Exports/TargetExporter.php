<?php

namespace App\Filament\Exports;

use App\Models\Target;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TargetExporter extends Exporter
{
    protected static ?string $model = Target::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('nama'),
            ExportColumn::make('register'),
            ExportColumn::make('luas'),
            ExportColumn::make('tahun_perolehan'),
            ExportColumn::make('alamat'),
            ExportColumn::make('penggunaan'),
            ExportColumn::make('asal'),
            ExportColumn::make('surveyor'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('user_id'),
            ExportColumn::make('lat'),
            ExportColumn::make('lng'),
            ExportColumn::make('sigis'),
            ExportColumn::make('kecamatan'),
            ExportColumn::make('kelurahan'),
            ExportColumn::make('opd'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your target export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
