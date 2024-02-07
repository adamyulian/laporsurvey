<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Detail;
use App\Models\Survey;
use App\Models\Target;
use App\Models\Target2;
use Filament\Forms\Get;
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
                    Forms\Components\ToggleButtons::make('kebersihan')
                        ->required()
                        ->live()
                        ->inline()
                        ->colors([
                            'Baik' => 'info',
                            'Kurang Baik' => 'warning',
                            'Kotor' => 'danger',
                        ])
                        ->icons([
                            'Baik' => 'heroicon-o-check-badge',
                            'Kurang Baik' => 'heroicon-o-shield-exclamation',
                            'Kotor' => 'heroicon-o-archive-box-x-mark',
                        ])
                        ->options([
                            'Baik' => 'Baik',
                            'Kurang Baik' => 'Kurang Baik',
                            'Kotor' => 'Rusak',
                            ])
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('ket_kebersihan')
                        ->hidden(fn (Get $get) => $get('kebersihan') === 'Baik' or $get('kebersihan') === null)
                        ->requiredUnless('kebersihan', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('speedometer')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_speedometer')
                        ->hidden(fn (Get $get) => $get('speedometer') === 'Baik' or $get('speedometer') === null)
                        ->requiredUnless('speedometer', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('tempat_duduk')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_tempat_duduk')
                        ->hidden(fn (Get $get) => $get('tempat_duduk') === 'Baik' or $get('tempat_duduk') === null)
                        ->requiredUnless('tempat_duduk', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('dashboard')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_dashboard')
                        ->hidden(fn (Get $get) => $get('dashboard') === 'Baik' or $get('dashboard') === null)
                        ->requiredUnless('dashboard', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('ac')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_ac')
                        ->hidden(fn (Get $get) => $get('ac') === 'Baik' or $get('ac') === null)
                        ->requiredUnless('ac', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('kaca_film')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_kaca_film')
                        ->hidden(fn (Get $get) => $get('kaca_film') === 'Baik' or $get('kaca_film') === null)
                        ->requiredUnless('kaca_film', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('toolkit')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_toolkit')
                        ->hidden(fn (Get $get) => $get('toolkit') === 'Baik' or $get('toolkit') === null)
                        ->requiredUnless('toolkit', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('gambar_interior')
                        ->label('Foto Kondisi Interior (Max. 2 Files)')
                        ->required()
                        ->image()
                        ->multiple(2),
                    Forms\Components\FileUpload::make('gambar_speedometer')
                        ->label('Foto Speedometer, Usahakan KM dan BBM jelas')
                        ->required()
                        ->image(),
                        ]),
                Section::make('Eksterior')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                    Forms\Components\ToggleButtons::make('body')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_body')
                        ->hidden(fn (Get $get) => $get('body') === 'Baik' or $get('body') === null)
                        ->requiredUnless('body', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('cat')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_cat')
                        ->hidden(fn (Get $get) => $get('cat') === 'Baik' or $get('cat') === null)
                        ->requiredUnless('cat', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('lampu_utama')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_lampu_utama')
                        ->hidden(fn (Get $get) => $get('lampu_utama') === 'Baik' or $get('lampu_utama') === null)
                        ->requiredUnless('lampu_utama', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('lampu_sein_depan')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_lampu_sein_depan')
                        ->hidden(fn (Get $get) => $get('lampu_sein_depan') === 'Baik' or $get('lampu_sein_depan') === null)
                        ->requiredUnless('lampu_sein_depan', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('lampu_sein_blkg')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_lampu_sein_blkg')
                        ->hidden(fn (Get $get) => $get('lampu_sein_blkg') === 'Baik' or $get('lampu_sein_blkg') === null)
                        ->requiredUnless('lampu_sein_blkg', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('lampu_rem')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_lampu_rem')
                        ->hidden(fn (Get $get) => $get('lampu_rem') === 'Baik' or $get('lampu_rem') === null)
                        ->requiredUnless('lampu_rem', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('ban_mobil')
                        ->required()
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
                    Forms\Components\Textarea::make('ket_ban_mobil')
                        ->hidden(fn (Get $get) => $get('ban_mobil') === 'Baik' or $get('ban_mobil') === null)
                        ->requiredUnless('ban_mobil', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('ban_serep')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_ban_serep')
                        ->hidden(fn (Get $get) => $get('ban_serep') === 'Baik' or $get('ban_serep') === null)
                        ->requiredUnless('ban_serep', 'Baik')
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
                    Forms\Components\Textarea::make('ket_klakson')
                        ->hidden(fn (Get $get) => $get('klakson') === 'Baik' or $get('klakson') === null)
                        ->requiredUnless('klakson', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('wiper')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_wiper')
                        ->hidden(fn (Get $get) => $get('wiper') === 'Baik' or $get('wiper') === null)
                        ->requiredUnless('wiper', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('spion')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_spion')
                        ->hidden(fn (Get $get) => $get('spion') === 'Baik' or $get('spion') === null)
                        ->requiredUnless('spion', 'Baik')
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
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_mesin')
                        ->hidden(fn (Get $get) => $get('mesin') === 'Baik' or $get('mesin') === null)
                        ->requiredUnless('mesin', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('accu')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_accu')
                        ->hidden(fn (Get $get) => $get('accu') === 'Baik' or $get('accu') === null)
                        ->requiredUnless('accu', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('rem')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_rem')
                        ->hidden(fn (Get $get) => $get('rem') === 'Baik' or $get('rem') === null)
                        ->requiredUnless('rem', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('transmisi')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_transmisi')
                        ->hidden(fn (Get $get) => $get('transmisi') === 'Baik' or $get('transmisi') === null)
                        ->requiredUnless('transmisi', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('power_steering')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_power_steering')
                        ->hidden(fn (Get $get) => $get('power_steering') === 'Baik' or $get('power_steering') === null)
                        ->requiredUnless('power_steering', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('radiator')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_radiator')
                        ->hidden(fn (Get $get) => $get('radiator') === 'Baik' or $get('radiator') === null)
                        ->requiredUnless('radiator', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('oli_mesin')
                        ->required()
                        ->live()
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
                    Forms\Components\Textarea::make('ket_oli_mesin')
                        ->hidden(fn (Get $get) => $get('oli_mesin') === 'Baik' or $get('oli_mesin') === null)
                        ->requiredUnless('oli_mesin', 'Baik')
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
                Tables\Columns\ImageColumn::make('gambar_interior'),
                Tables\Columns\ImageColumn::make('gambar_eksterior'),
                Tables\Columns\ImageColumn::make('gambar_mesin'),
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
                    ->collapsible()
                    ->columns(4)
                    ->schema([
                        TextEntry::make('target2.nopol')
                            ->columnSpan(2)
                            ->label('Nomor Polisi')
                            ->weight(FontWeight::Bold)
                            ->size(TextEntry\TextEntrySize::Large),
                        TextEntry::make('target2.opd')
                            ->columnSpan(2)
                            ->label('Perangkat Daerah')
                            ->weight(FontWeight::Bold)
                            ->size(TextEntry\TextEntrySize::Large),
                        TextEntry::make('target2.merk')
                            ->columnSpan(2)
                            ->label('Merk'),
                        TextEntry::make('target2.tipe')
                            ->columnSpan(2)
                            ->label('Tipe'),  
                        TextEntry::make('target2.jabatan')
                            ->columnSpan(2)
                            ->label('Penggunaan Kendaraan'),
                        TextEntry::make('target2.tahun')
                            ->columnSpan(2)
                            ->label('Tahun'),
                    ]),
                    Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Interior')
                            ->columns(4)
                            ->schema([
                                TextEntry::make('tempat_duduk')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),                            
                                TextEntry::make('dashboard')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }), 
                                TextEntry::make('ac')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }), 
                                TextEntry::make('kaca_film')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                TextEntry::make('toolkit')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }), 
                                InfolistSection::make('Gambar')
                                ->collapsible()
                                ->collapsed(true)
                                ->schema([
                                    ImageEntry::make('gambar_interior')
                                    ->columnSpanFull()
                                    ->size(760),
                                ])
                            ]),
                        Tabs\Tab::make('Eksterior')
                            ->columns(4)
                            ->schema([
                                TextEntry::make('body')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                TextEntry::make('cat')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                TextEntry::make('lampu_utama')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                TextEntry::make('lampu_sein_depan')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                TextEntry::make('lampu_sein_blkg')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }), 
                                TextEntry::make('lampu_rem')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }), 
                                TextEntry::make('ban_mobil')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }), 
                                TextEntry::make('ban_serep')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                TextEntry::make('klakson')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                TextEntry::make('wiper')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                TextEntry::make('spion')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                InfolistSection::make('Gambar')
                                ->collapsible()
                                ->collapsed(true)
                                ->schema([
                                    ImageEntry::make('gambar_eksterior')
                                    ->columnSpanFull()
                                    ->size(760),
                                ])
                            ]),
                        Tabs\Tab::make('Mesin')
                            ->columns(4)
                            ->schema([
                                TextEntry::make('mesin')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                TextEntry::make('accu')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                TextEntry::make('rem')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                TextEntry::make('transmisi')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                TextEntry::make('power_steering')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                TextEntry::make('radiator')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                TextEntry::make('oli_mesin')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Baik' => 'info',
                                    'Kurang Baik' => 'warning',
                                    'Rusak' => 'danger',
                                }),
                                InfolistSection::make('Gambar')
                                ->collapsible()
                                ->collapsed(true)
                                ->schema([
                                    ImageEntry::make('gambar_mesin')
                                    ->columnSpanFull()
                                    ->size(760),
                                ])
                            ]),
                    ]),
                  
                ])->columnSpan(4),
                Group::make([
                    InfolistSection::make([
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('published_at')
                            ->dateTime(),
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
