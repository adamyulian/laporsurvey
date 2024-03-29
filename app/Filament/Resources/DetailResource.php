<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Detail;
use App\Models\Survey;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Databangunan;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Tables\Grouping\Group;
use Illuminate\Support\Facades\Auth;
use App\Filament\Exports\DetailExporter;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DetailResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DetailResource\RelationManagers;

class DetailResource extends Resource
{
    protected static ?string $model = Detail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Kondisi Aset Tanah';

    protected static ?string $navigationLabel = 'Detail Penggunaan';

    protected static ?string $recordTitleAttribute = 'Detail Penggunaan';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('survey_id')
                        ->native(false)
                        ->required()
                        ->preload()
                        ->relationship(
                            name: 'Survey',
                            titleAttribute: 'nama',
                            modifyQueryUsing: function (Builder $query) {
                                if (Auth::user()->role === 'admin') {
                                    return $query;
                                }

                                // Non-admin users can only view their own component
                                // return
                                $userId = Auth::user()->id;
                                $query->where('user_id', $userId)
                                ;}
                            )
                        ->getOptionLabelFromRecordUsing(fn (Survey $record) => "{$record->target->register} {$record->target->nama} {$record->target->alamat}"),
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
                                'Makam' => 'Makam'
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
                            ->image(),

                Forms\Components\TextInput::make('id_penggunaan')
                            ->maxLength(255)
                            ->live(),
                Forms\Components\Select::make('regbangunan')
                            ->native(false)
                            ->required()
                            ->preload()
                            ->options(fn (Get $get): Collection => Databangunan::query()
                                    ->where('register_tanah', explode('.', $get('id_penggunaan'))[0])
                                    ->pluck('nama_bangunan','register_bangunan'))
                            // ->relationship(
                            //     name: 'Databangunan',
                            //     titleAttribute: 'nama',
                            //     modifyQueryUsing: function (Builder $query) {
                            //         if (Auth::user()->role === 'admin') {
                            //             return function ($get) {
                            //                 $register = Survey::find($get('survey_id'))->get();
                            //                 $query->where('register_tanah', $register );
                            //             };
                            //         }

                            //         // Non-admin users can only view their own component
                            //         // return
                            //         $userId = Auth::user()->id;
                            //         $query->where('user_id', $userId)
                            //         ;}
                            //     )
                            // ->getOptionLabelFromRecordUsing(fn (Databangunan $record) => "{$record->register_bangunan} {$record->nama_bangunan} {$record->alamat_bangunan}"),
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
                //return
                    $userId = Auth::user()->id;
                    // $query->where('survey.user.id', $teamId);
                    $query->whereHas('survey', function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })->get();
                })
            ->defaultSort(column:'created_at', direction:'desc')
            ->groups([
                Group::make('survey.target.register')
                    ->titlePrefixedWithLabel(false)
                    ->label('register'),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('id_penggunaan')
                    ->label('ID Penggunaan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('penggunaan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('luas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('detail')
                    ->wrap()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kondisi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('foto_penggunaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hub_hukum')
                    ->searchable(),
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
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(DetailExporter::class)
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
            'index' => Pages\ListDetails::route('/'),
            'create' => Pages\CreateDetail::route('/create'),
            'view' => Pages\ViewDetail::route('/{record}'),
            'edit' => Pages\EditDetail::route('/{record}/edit'),
        ];
    }
}
