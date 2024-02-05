<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Detail;
use App\Models\Survey;
use App\Models\Target;
use App\Models\Target2;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Surveykendaraan;
use App\Models\TargetKendaraan;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Group;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SurveykendaraanResource\Pages;
use Filament\Infolists\Components\Section as InfolistSection;
use App\Filament\Resources\SurveykendaraanResource\RelationManagers;

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
                        Forms\Components\Select::make('target2_id')
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
                        Forms\Components\ToggleButtons::make('tempat_duduk')
                        ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('dashboard')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('ac')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('kaca_film')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('toolkit')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('gambar_interior')
                        ->image()
                        ->multiple(2),
                        ]),
                Section::make('Eksterior')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        Forms\Components\ToggleButtons::make('body')
                        ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('cat')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('lampu_utama')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('lampu_sein_depan')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
,
                    Forms\Components\ToggleButtons::make('lampu_sein_blkg')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('lampu_rem')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('ban_mobil')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('ban_serep')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('klakson')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('wiper')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('spion')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])

                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('gambar_eksterior')
                        ->image()
                        ->multiple(),
                        ]),
                Section::make('Mesin')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        Forms\Components\ToggleButtons::make('mesin')
                        ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])

                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('accu')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])

                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('rem')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])

                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('transmisi')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])

                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('power_steering')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])

                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('radiator')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])

                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('oli_mesin')
                    ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Rusak' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Rusak' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Rusak' => 'Rusak',
                            ])

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
                Tables\Columns\TextColumn::make('target2.opd')
                    ->label('Kendaraan')
                    ->description(fn (Surveykendaraan $record): string => $record->target2->nopol )
                    ->searchable(),
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
    
    public static function infolist(Infolist $infolist): Infolist

    {
        return $infolist
            ->schema([
                Group::make([
                    InfolistSection::make('Informasi Kendaraan')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('target2.nopol')
                            ->columnSpan(2)
                            ->label('Nomor Polisi')
                            ->weight(FontWeight::Bold)
                            ->size(TextEntry\TextEntrySize::Large),
                        TextEntry::make('target2.opd')
                            ->columnSpan(2)
                            ->label('Perangkat Daerah'),
                        TextEntry::make('target2.merk')
                            ->columnSpan(2)
                            ->label('Merk'),
                        TextEntry::make('target2.tipe')
                            ->columnSpan(2)
                            ->label('Tipe'),  
                        TextEntry::make('target2.jabatan')
                            ->columnSpan(2)
                            ->label('Jabatan'),
                        TextEntry::make('target2.tahun')
                            ->columnSpan(2)
                            ->label('Alamat'),
                    ]),
                    Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Interior')
                            ->schema([
                                TextEntry::make('tempat_duduk')
                                ->columnSpan(2)
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'success',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),                            
                                // ->icons(fn (string $state): string => match ($state) {
                                //     'Baik' => 'heroicon-o-check-badge',
                                //     'Kurang Baik' => 'heroicon-o-shield-exclamation',
                                //     'Rusak' => 'heroicon-o-archive-box-x-mark',
                                // }),
                                TextEntry::make('dashboard')
                                ->columnSpan(2)
                                ->colors([
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                ])
                                ->icons([
                                    'Baik' => 'heroicon-o-check-badge',
                                    'Kurang Baik' => 'heroicon-o-shield-exclamation',
                                    'Rusak' => 'heroicon-o-archive-box-x-mark',
                                ]),
                                TextEntry::make('ac')
                                ->columnSpan(2)
                                ->colors([
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                ])
                                ->icons([
                                    'Baik' => 'heroicon-o-check-badge',
                                    'Kurang Baik' => 'heroicon-o-shield-exclamation',
                                    'Rusak' => 'heroicon-o-archive-box-x-mark',
                                ]),
                                TextEntry::make('kaca_film')
                                ->columnSpan(2)
                                ->colors([
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                ])
                                ->icons([
                                    'Baik' => 'heroicon-o-check-badge',
                                    'Kurang Baik' => 'heroicon-o-shield-exclamation',
                                    'Rusak' => 'heroicon-o-archive-box-x-mark',
                                ]),
                            ]),
                        Tabs\Tab::make('Eksterior')
                            ->schema([
                                // ...
                            ]),
                        Tabs\Tab::make('Mesin')
                            ->schema([
                                // ...
                            ]),
                    ]),
                  
                ])->columnSpan(4),
                Group::make([
                    InfolistSection::make([
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('published_at')
                            ->dateTime(),
                        TextEntry::make('lat'),
                        TextEntry::make('lng'),
                        TextEntry::make('address')
                                ->label('Location Data Saved'),
                        TextEntry::make('surveyor.nama')
                                ->label('Surveyor')
                    ])
                ])->columnSpan(1)
            ])->columns(5);
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
