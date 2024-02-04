<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\SurveyResource;
use Filament\Tables;
use App\Models\Survey;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestSurveys extends BaseWidget
{
    protected static ?int $sort = 4;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Survey Pemanfaatan Aset Tanah')
            ->query(SurveyResource::getEloquentQuery())
            ->defaultPaginationPageOption(option:5)
            ->defaultSort(column:'created_at', direction:'desc')
            ->columns([
            Tables\Columns\TextColumn::make('target.nama')
                ->description(fn (Survey $record): string => $record->target->register)
                ->limit(25)
                ->sortable()
                ->searchable(),
            Tables\Columns\IconColumn::make('status')
                ->alignCenter()
                ->label('Digunakan/Dimanfaatkan')
                ->boolean(),
            Tables\Columns\TextColumn::make('guna')
                ->label('Digunakan sebagai')
                ->searchable(),
            Tables\Columns\TextColumn::make('hubungan_hukum')
                ->label('Hub. Hukum')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'belum' => 'danger',
                    'sudah_habis' => 'warning',
                    'ada' => 'success',})
                ->searchable(),
            Tables\Columns\TextColumn::make('team.name')
                ->label('Team')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Group 1' => 'danger',
                    'Group 2' => 'warning',
                    'Group 3' => 'success',
                    'Group 4' => 'info',})
                ->searchable(),
            Tables\Columns\TextColumn::make('surveyor.nama')
                ->label('Surveyor')
                ->searchable()
                ->listWithLineBreaks()
                ->limitList(3),
            ]);
    }
}
