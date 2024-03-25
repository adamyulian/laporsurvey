<?php

namespace App\Filament\Resources\SurveyResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Survey;
use App\Models\Target;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

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
                                'Balai RT/RW' => 'Balai RT/RW',
                                'Bangunan Kosong' => 'Bangunan Kosong',
                                'Bisnis/Komersial' => 'Bisnis/Komersial',
                                'Fasilitas Umum' => 'Fasilitas Umum',
                                'Gedung Serbaguna' => 'Gedung Serbaguna',
                                'Jalan' => 'Jalan',
                                'Kantor' => 'Kantor',
                                'Makam' => 'Makam',
                                'Ruang Terbuka Hijau' => 'Ruang Terbuka Hijau',
                                'Rumah Ibadah' => 'Rumah Ibadah',
                                'Rumah Tinggal' => 'Rumah Tinggal',
                                'Sawah/Kebun' => 'Sawah/Kebun',
                                'Sekolah' => 'Sekolah',
                                'Taman' => 'Taman',
                                'Tambak' => 'Tambak',
                                'Tanah Kosong' => 'Tanah Kosong',
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
                Forms\Components\Select::make('kondisi')
                    ->required()
                    ->native(false)
                            ->options([
                                'Tidak Terawat' => 'Tidak Terawat',
                                'Terawat' => 'Terawat',
                            ]),
                Forms\Components\Select::make('hub_hukum')
                            ->required()
                            ->native(false)
                                    ->options([
                                        'Ada' => 'Ada',
                                        'Tidak Ada' => 'Tidak Ada',
                                        'Digunakan Pemkot Sendiri' => 'Digunakan Pemkot Sendiri',
                                    ]),
                Forms\Components\FileUpload::make('foto_penggunaan')
                            ->required()
                            ->image()
                            ->visibility('public')
                            ->openable()
                            ->downloadable()
                            ->fetchFileInformation(false)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Detail Penggunaan')
            ->recordTitleAttribute('penggunaan')
            ->columns([
                // Tables\Columns\TextColumn::make('survey.target.register'),
                Tables\Columns\TextColumn::make('id_penggunaan')
                    ->label('Register Penggunaan'),
                Tables\Columns\TextColumn::make('penggunaan'),
                Tables\Columns\TextColumn::make('detail'),
                Tables\Columns\TextColumn::make('luas')
                ->label('Luas (M2)'),
                Tables\Columns\TextColumn::make('kondisi'),
                Tables\Columns\ImageColumn::make('foto_penggunaan'),
                Tables\Columns\TextColumn::make('regbangunan')
                ->label('Register Bang'),

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
