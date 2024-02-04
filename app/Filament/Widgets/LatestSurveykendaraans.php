<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\SurveykendaraanResource;
use Filament\Tables;
use App\Models\Surveykendaraan;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestSurveykendaraans extends BaseWidget
{
    protected static ?int $sort = 5;

    public static function canView(): bool
    {
        return auth()->user()->role === 'admin' or auth()->user()->penyelia === '1' ;
    }
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Survey Aset Kendaraan')
            ->query(SurveykendaraanResource::getEloquentQuery())
            ->defaultPaginationPageOption(option:5)
            ->defaultSort(column:'created_at', direction:'desc')
            ->columns([
            Tables\Columns\TextColumn::make('target2.nopol')
                ->description(fn (Surveykendaraan $record): string => $record->target2->tipe)
                ->limit(25)
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('user.name')
                ->label('Name')
                ->badge()
                ->searchable(),
            ]);
    }
}
