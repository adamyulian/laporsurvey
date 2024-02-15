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
                                'Bangunan Kosong' => 'Bangunan Kosong',
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('penggunaan')
            ->columns([
                Tables\Columns\TextColumn::make('survey.target.register.'),
                // ->state(function (Survey $survey) {
                //     $register = Target::where('survey_id', $survey->id)->value('register');
        
                //     // Define a mapping between rows and letters to append
                //     $appendLetters = ['a', 'b', 'c', 'd', 'e'];

                //     // Calculate the index based on the row count
                //     $rowIndex = $this->getIndex(); // Assuming you're using Livewire or similar
                //     $appendIndex = $rowIndex % count($appendLetters);

                //     // Append the letter to the register value
                //     return $register . ' ' . $appendLetters[$appendIndex];
                // }),
                // Tables\Columns\TextColumn::make('survey.target.register')
                // ->state(function (Survey $survey) {
                //     $register = Target::where('survey_id', $survey->id)->value('register');
        
                //     // Define a mapping between rows and letters to append
                //     $appendLetters = ['a', 'b', 'c', 'd', 'e'];

                //     // Calculate the index based on the row count
                //     $rowIndex = $this->getIndex(); // Assuming you're using Livewire or similar
                //     $appendIndex = $rowIndex % count($appendLetters);

                //     // Append the letter to the register value
                //     return $register . ' ' . $appendLetters[$appendIndex];
                // }),
                Tables\Columns\TextColumn::make('penggunaan'),
                Tables\Columns\TextColumn::make('detail'),
                Tables\Columns\TextColumn::make('luas')
                ->label('Luas (M2)'),
                Tables\Columns\TextColumn::make('kondisi'),
                Tables\Columns\ImageColumn::make('foto_penggunaan'),
                
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
