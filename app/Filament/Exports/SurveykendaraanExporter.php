<?php

namespace App\Filament\Exports;

use App\Models\Surveykendaraan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

use function PHPSTORM_META\map;

class SurveykendaraanExporter extends Exporter
{
    protected static ?string $model = Surveykendaraan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('target2.nopol')
                ->label('nopol'),
            ExportColumn::make('target2.opd')
                ->label('opd'),
            ExportColumn::make('target2.tahun')
                ->label('tahun'),
            ExportColumn::make('target2.merk')
                ->label('merk'),
            ExportColumn::make('target2.tipe')
                ->label('tipe'),
            ExportColumn::make('target2.jabatan')
                ->label('jabatan'),
            ExportColumn::make('kilometer'),
            ExportColumn::make('merk_ban'),
            ExportColumn::make('tahun_ban'),
            ExportColumn::make('merk_accu'),
            ExportColumn::make('masa_pajak'),
            ExportColumn::make('informasi_tambahan'),
            ExportColumn::make('group1_total_value')
                ->label('total nilai interior'),
            ExportColumn::make('group2_total_value')
                ->label('total nilai eksterior'),
            ExportColumn::make('group3_total_value')
                ->label('total nilai mesin'),
            ExportColumn::make('overall_total_value')
                ->label('total nilai keseluruhan'),
            ExportColumn::make('speedometer'),
            ExportColumn::make('kebersihan'),
            ExportColumn::make('tempat_duduk'),
            ExportColumn::make('dashboard'),
            ExportColumn::make('ac'),
            ExportColumn::make('kaca_film'),
            ExportColumn::make('toolkit'),
            ExportColumn::make('body'),
            ExportColumn::make('cat'),
            ExportColumn::make('lampu_utama'),
            ExportColumn::make('lampu_sein_depan'),
            ExportColumn::make('lampu_sein_blkg'),
            ExportColumn::make('lampu_kabut'),
            ExportColumn::make('lampu_mundur'),
            ExportColumn::make('lampu_rem'),
            ExportColumn::make('ban_mobil'),
            ExportColumn::make('ban_serep'),
            ExportColumn::make('klakson'),
            ExportColumn::make('wiper'),
            ExportColumn::make('spion'),
            ExportColumn::make('mesin'),
            ExportColumn::make('accu'),
            ExportColumn::make('rem'),
            ExportColumn::make('transmisi'),
            ExportColumn::make('power_steering'),
            ExportColumn::make('radiator'),
            ExportColumn::make('oli_mesin'),
            ExportColumn::make('ket_speedometer'),
            ExportColumn::make('ket_kebersihan'),
            ExportColumn::make('ket_tempat_duduk'),
            ExportColumn::make('ket_dashboard'),
            ExportColumn::make('ket_ac'),
            ExportColumn::make('ket_kaca_film'),
            ExportColumn::make('ket_toolkit'),
            ExportColumn::make('ket_body'),
            ExportColumn::make('ket_cat'),
            ExportColumn::make('ket_lampu_utama'),
            ExportColumn::make('ket_lampu_sein_depan'),
            ExportColumn::make('ket_lampu_sein_blkg'),
            ExportColumn::make('ket_lampu_rem'),
            ExportColumn::make('ket_lampu_kabut'),
            ExportColumn::make('ket_lampu_mundur'),
            ExportColumn::make('ket_ban_mobil'),
            ExportColumn::make('ket_ban_serep'),
            ExportColumn::make('ket_klakson'),
            ExportColumn::make('ket_wiper'),
            ExportColumn::make('ket_spion'),
            ExportColumn::make('ket_mesin'),
            ExportColumn::make('ket_accu'),
            ExportColumn::make('ket_rem'),
            ExportColumn::make('ket_transmisi'),
            ExportColumn::make('ket_power_steering'),
            ExportColumn::make('ket_radiator'),
            ExportColumn::make('ket_oli_mesin'),
           
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your Survey export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
