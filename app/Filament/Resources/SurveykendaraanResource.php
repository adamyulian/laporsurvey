<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Surveykendaraan;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SurveykendaraanResource\Pages;
use App\Filament\Resources\SurveykendaraanResource\RelationManagers;
use App\Models\Target2;
use App\Models\TargetKendaraan;

class SurveykendaraanResource extends Resource
{
    protected static ?string $model = Surveykendaraan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Survey';

    protected static ?string $recordTitleAttribute = 'Survey';

    protected static ?string $navigationGroup = 'Kondisi Aset Kendaraan';

    protected ?string $heading = 'Survey Kendaraan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Target')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        Forms\Components\Select::make('target_kendaraan_id')
                        ->label('Silakan memilih Nopol/Target Survey')
                        ->preload()
                        ->relationship(
                            name: 'Target2', 
                            titleAttribute: 'nopol',
                            modifyQueryUsing: function (Builder $query) {
                                if (Auth::user()->role === 'admin') {
                                    return $query;
                                }
                        
                                // Non-admin users can only view their own component
                                // return 
                                $nameUser = Auth::user()->name;
                                $query->where('nama_penyelia', $nameUser)
                                ->where('status', 0)
                                ;}
                            )
                        ->getOptionLabelFromRecordUsing(fn (Target2 $record) => "{$record->nopol} {$record->merk} {$record->tipe}")
                        ->searchable(['nopol'])
                    ]),
                Section::make('Interior')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        Forms\Components\Select::make('tempat_duduk')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('dashboard')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('ac')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('kaca_film')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('toolkit')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('gambar_interior')
                        ->image()
                        ->multiple(2),
                        ]),
                Section::make('Eksterior')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        Forms\Components\Select::make('body')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('cat')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('lampu_utama')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('lampu_sein_depan')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false),
                    Forms\Components\Select::make('lampu_sein_blkg')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('lampu_rem')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('ban_mobil')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('ban_serep')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('klakson')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('wiper')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('spion')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('gambar_eksterior')
                        ->image()
                        ->multiple(),
                        ]),
                Section::make('Mesin')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        Forms\Components\Select::make('mesin')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('accu')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('rem')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('transmisi')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('power_steering')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('radiator')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('oli_mesin')
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->native(false)
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('gambar_mesin')
                        ->image()
                        ->multiple(),
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
                $user_id = Auth::user()->id;
                $query->where('user_id', $user_id);
            })
            ->columns([
                Tables\Columns\TextColumn::make('tempat_duduk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dashboard')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ac')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kaca_film')
                    ->searchable(),
                Tables\Columns\TextColumn::make('toolkit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('body')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lampu_utama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lampu_sein_depan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lampu_sein_blkg')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lampu_rem')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ban_mobil')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ban_serep')
                    ->searchable(),
                Tables\Columns\TextColumn::make('klakson')
                    ->searchable(),
                Tables\Columns\TextColumn::make('wiper')
                    ->searchable(),
                Tables\Columns\TextColumn::make('spion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mesin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('accu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rem')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transmisi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('power_steering')
                    ->searchable(),
                Tables\Columns\TextColumn::make('radiator')
                    ->searchable(),
                Tables\Columns\TextColumn::make('oli_mesin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gambar_interior')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gambar_eksterior')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gambar_mesin')
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
                    ->label('New Survey'),
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
            'index' => Pages\ListSurveykendaraans::route('/'),
            'create' => Pages\CreateSurveykendaraan::route('/create'),
            'view' => Pages\ViewSurveykendaraan::route('/{record}'),
            'edit' => Pages\EditSurveykendaraan::route('/{record}/edit'),
        ];
    }    
}
