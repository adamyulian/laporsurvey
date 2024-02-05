<?php

namespace App\Filament\Resources\SurveyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetailRelationManager extends RelationManager
{
    protected static string $relationship = 'detail';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('penggunaan')
                            ->native(false)
                            ->options([
                                'Rumah Ibadah' => 'Rumah Ibadah',
                                'Bisnis/Komersial' => 'Bisnis/Komersial',
                                'Fasilitas Umum' => 'Fasilitas Umum',
                                'Kantor' => 'Kantor',
                                'Ruang Terbuka Hijau' => 'Ruang Terbuka Hijau',
                                'Taman' => 'Taman',
                                'Rumah Tinggal' => 'Rumah Tinggal',
                                'Sekolah' => 'Sekolah',
                                'Balai RT/RW' => 'Balai RT/RW',
                                'Gedung Serbaguna' => 'Gedung Serbaguna',
                                'Tanah Kosong' => 'Tanah Kosong',
                                'Jalan' => 'Jalan',
                                'Sawah/Kebun' => 'Sawah/Kebun',
                                'Tambak' => 'Tambak',
                            ])
                            ->label('Nama Penggunaan/Pemanfaatan'),
                Forms\Components\Textarea::make('detail')
                            ->label('Detail Penggunaan')
                            ->placeholder('Jika digunakan sebagai Rumah Ibadah rincikan namanya, Contoh : Masjid Ulil Albaab')
                            ->required(),
                Forms\Components\TextInput::make('luas')
                    ->required()
                    ->numeric()
                    ->suffix('M2'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('penggunaan')
            ->columns([
                Tables\Columns\TextColumn::make('penggunaan'),
                Tables\Columns\TextColumn::make('luas')
                ->label('Luas (M2)'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    public function isReadOnly(): bool
        {
            return false;
        }
}
