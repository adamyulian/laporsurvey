<?php

namespace App\Filament\Resources;

use App\Filament\Exports\Target2Exporter;
use Filament\Forms;
use Filament\Tables;
use App\Models\Target2;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Target2Resource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Target2Resource\RelationManagers;

class Target2Resource extends Resource
{
    protected static ?string $model = Target2::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Target Kendaraan';

    protected static ?string $recordTitleAttribute = 'Target';

    protected static ?string $navigationGroup = 'Kondisi Aset Kendaraan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nopol')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahun')
                    ->maxLength(255),
                Forms\Components\TextInput::make('merk')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tipe')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jabatan')
                    ->maxLength(255),
                Forms\Components\Select::make('opd')
                    ->native(false)
                    ->searchable()
                    ->options([
                        'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA',
                        'BADAN KESATUAN BANGSA, POLITIK DAN PERLINDUNGAN MASYARAKAT',
                        'BADAN PENANGGULANGAN BENCANA',
                        'BADAN PENDAPATAN DAN PAJAK DAERAH',
                        'BADAN PENGELOLAHAN KEUANGAN DAN ASET DAERAH',
                        'BADAN PERENCANAAN PEMBANGUNAN DAERAH, PENELITIAN DAN PENGEMBANGAN',
                        'BAGIAN HUKUM DAN KERJASAMA',
                        'BAGIAN ORGANISASI',
                        'BAGIAN PEMERINTAHAN DAN KESEJAHTERAAN RAKYAT',
                        'BAGIAN PENGADAAN BARANG/JASA DAN ADMINISTRASI PEMBANGUNAN',
                        'BAGIAN PEREKONOMIAN DAN SUMBER DAYA ALAM',
                        'BAGIAN UMUM, PROTOKOL DAN KOMUNIKASI PIMPINAN',
                        'DINAS KEBUDAYAAN, KEPEMUDAAN DAN OLAHRAGA SERTA PARIWISATA',
                        'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL',
                        'DINAS KESEHATAN',
                        'DINAS KETAHANAN PANGAN DAN PERTANIAN',
                        'DINAS KOMUNIKASI DAN INFORMATIKA',
                        'DINAS KOPERASI USAHA KECIL DAN MENENGAH DAN PERDAGANGAN',
                        'DINAS LINGKUNGAN HIDUP',
                        'DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN',
                        'DINAS PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK SERTA PENGENDALIAN PENDUDUK DAN KELUARGA BERENCANA',
                        'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU',
                        'DINAS PENDIDIKAN',
                        'DINAS PERHUBUNGAN',
                        'DINAS PERINDUSTRIAN DAN TENAGA KERJA',
                        'DINAS PERPUSTAKAAN DAN KEARSIPAN',
                        'DINAS PERUMAHAN RAKYAT DAN PEMUKIMAN SERTA PERTANAHAN',
                        'DINAS SOSIAL',
                        'DINAS SUMBER DAYA AIR DAN BINA MARGA',
                        'INSPEKTORAT DAERAH',
                        'RSUD BHAKTI DHARMA HUSADA',
                        'RSUD DR SOEWANDHIE',
                        'SATUAN POLISI PAMONG PRAJA',
                        'SEKRETARIAT DPRD'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {

            if (Auth::user()->role === 'admin') {
                return $query;
            }
    
            // Non-admin users can only view their own component
            // return 
                $name = Auth::user()->name;
                $query->where('nama_penyelia', $name);
            })
            ->columns([
                Tables\Columns\TextColumn::make('nopol')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun')
                    ->searchable(),
                Tables\Columns\TextColumn::make('merk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipe')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan')
                    ->description(fn (Target2 $record): string => $record->opd)
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_penyelia')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                ->label('Buat Target Baru'),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(Target2Exporter::class)
                    ->label('Download Data')
                    ->color('info')
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTarget2s::route('/'),
            'create' => Pages\CreateTarget2::route('/create'),
            'view' => Pages\ViewTarget2::route('/{record}'),
            'edit' => Pages\EditTarget2::route('/{record}/edit'),
        ];
    }    
}
