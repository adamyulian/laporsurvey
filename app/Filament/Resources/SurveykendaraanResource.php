<?php

namespace App\Filament\Resources;

use App\Filament\Exports\SurveykendaraanExporter;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Components\Group;
use Filament\Tables\Actions\ExportAction;
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

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

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
                    ->collapsed(false)
                    ->schema([
                        Forms\Components\Select::make('target2_id')
                        ->label('Silakan memilih Nopol/Target Survey')
                        ->preload()
                        ->required()
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
                            'Rusak' => 'Kotor',
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
                        ->label('toolkit/dongkrak')
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
                        ->multiple()
                        ->previewable(false)
                        ->openable()
                        ->maxFiles(2),
                    Forms\Components\FileUpload::make('gambar_speedometer')
                        ->label('Foto Speedometer, Usahakan KM dan BBM jelas')
                        ->required()
                        ->image()
                        ->previewable(false)
                        ->openable(),
                    Forms\Components\TextInput::make('kilometer')
                        ->numeric()
                        ->required()
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
                        Forms\Components\ToggleButtons::make('lampu_kabut')
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
                    Forms\Components\Textarea::make('ket_lampu_kabut')
                        ->hidden(fn (Get $get) => $get('lampu_kabut') === 'Baik' or $get('lampu_kabut') === null)
                        ->requiredUnless('lampu_kabut', 'Baik')
                        ->columnSpanFull(),
                    Forms\Components\ToggleButtons::make('lampu_mundur')
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
                    Forms\Components\Textarea::make('ket_lampu_mundur')
                        ->hidden(fn (Get $get) => $get('lampu_mundur') === 'Baik' or $get('lampu_mundur') === null)
                        ->requiredUnless('lampu_mundur', 'Baik')
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
                    Forms\Components\TextInput::make('merk_ban')
                        ->required(),
                    Forms\Components\TextInput::make('tahun_ban')
                        ->numeric()
                        ->required(),
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
                        ->live()
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
                        ->label('Foto Kondisi Eksterior (Max. 2 Files)')
                        ->image()
                        ->required()
                        ->multiple(2)
                        ->previewable(false)
                        ->openable()
                        ->maxFiles(2),
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
                    Forms\Components\TextInput::make('merk_accu')
                        ->required(),
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
                        ->label('Foto Kondisi Mesin (Max. 2 Files)')
                        ->required()
                        ->image()
                        ->multiple(2)
                        ->previewable(false)
                        ->openable()
                        ->maxFiles(2),
                        ]),
                Section::make('Informasi Tambahan')
                        ->collapsible()
                        ->collapsed(true)
                        ->schema([
                            Forms\Components\DatePicker::make('masa_pajak')
                                ->required(),
                            Forms\Components\Textarea::make('informasi_tambahan')
                                ->required()
                        ])
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
                    ->wrap()
                    ->limit(25)
                    ->description(fn (Surveykendaraan $record): string => $record->target2->nopol )
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_duduk')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('dashboard')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('ac')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('kaca_film')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('toolkit')
                ->label('toolkit/dongkrak')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('body')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('cat')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('lampu_utama')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('lampu_sein_depan')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('lampu_sein_blkg')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('lampu_rem')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('ban_mobil')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('ban_serep')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('klakson')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('wiper')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('spion')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('mesin')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('accu')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('rem')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('transmisi')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('power_steering')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('radiator')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('oli_mesin')
                ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('group1_total_value')
                    ->label('Interior')
                    ->alignCenter()
                    ->size(TextColumn\TextColumnSize::Medium),
                Tables\Columns\TextColumn::make('group2_total_value')
                    ->label('Eksterior')
                    ->alignCenter()
                    ->size(TextColumn\TextColumnSize::Medium),
                Tables\Columns\TextColumn::make('group3_total_value')
                    ->label('Mesin')
                    ->alignCenter()
                    ->size(TextColumn\TextColumnSize::Medium),
                Tables\Columns\TextColumn::make('overall_total_value')
                    ->alignCenter()
                    ->label('Total')
                    ->size(TextColumn\TextColumnSize::Large)
                    ->weight(FontWeight::Bold)
                    ->color('info'),
                Tables\Columns\ImageColumn::make('gambar_speedometer')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('gambar_interior')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('gambar_eksterior'),
                Tables\Columns\ImageColumn::make('gambar_mesin')
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
                    ->label('New Survey'),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(SurveykendaraanExporter::class)
            ]);;
    }
    
    public static function infolist(Infolist $infolist): Infolist

    {
        return $infolist
            ->schema([
                Group::make([
                    InfolistSection::make('Informasi Kendaraan')
                    ->collapsible()
                    ->columnSpan(3)
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
                    InfolistSection::make('Informasi Kendaraan')
                        ->collapsible()
                        ->columnSpan(3)
                        ->columns(4)
                        ->schema([
                            TextEntry::make('kilometer')
                                ->label('Kilometer'),
                            TextEntry::make('merk_ban')
                                ->label('Merk Ban'),
                            TextEntry::make('tahun_ban')
                                ->label('Tahun Ban'),
                            TextEntry::make('merk_accu')
                                ->label('Merk Accu'),
                            TextEntry::make('masa_pajak')
                                ->label('Masa Pajak'),
                            TextEntry::make('informasi_tambahan')
                                ->label('Informasi Tambahan'),
                        ]),
                    InfolistSection::make('Kondisi Kendaraan')
                        ->collapsible()
                        ->columnSpan(3)
                        ->columns(4)
                        ->schema([
                            Tabs::make('Tabs')
                                ->columnSpan(4)
                                ->tabs([
                                    Tabs\Tab::make('Interior')
                                        ->columns(3)
                                        ->schema([
                                            TextEntry::make('tempat_duduk')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_tempat_duduk')
                                            ->columnSpan(2)
                                            ->label('Keterangan Tempat Duduk'),                          
                                            TextEntry::make('dashboard')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }), 
                                            TextEntry::make('ket_dashboard')
                                            ->columnSpan(2)
                                            ->label('Keterangan Dashboard'),
                                            TextEntry::make('ac')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }), 
                                            TextEntry::make('ket_ac')
                                            ->columnSpan(2)
                                            ->label('Keterangan AC'),
                                            TextEntry::make('kaca_film')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_kaca_film')
                                            ->columnSpan(2)
                                            ->label('Keterangan Kaca Film'),
                                            TextEntry::make('toolkit')
                                            ->label('Toolkit / Dongkrak')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_toolkit')
                                            ->columnSpan(2)
                                            ->label('Keterangan Toolkit'),
                                        ]),
                                    Tabs\Tab::make('Eksterior')
                                        ->columns(3)
                                        ->schema([
                                            TextEntry::make('body')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_body')
                                            ->columnSpan(2)
                                            ->label('Keterangan Body'),
                                            TextEntry::make('cat')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_cat')
                                            ->columnSpan(2)
                                            ->label('Keterangan Cat'),
                                            TextEntry::make('lampu_utama')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_lampu_utama')
                                            ->columnSpan(2)
                                            ->label('Keterangan Lampu Utama'),
                                            TextEntry::make('lampu_sein_depan')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_lampu_sein_depan')
                                            ->columnSpan(2)
                                            ->label('Keterangan Lampu Sein Depan'),
                                            TextEntry::make('lampu_sein_blkg')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }), 
                                            TextEntry::make('ket_lampu_sein_blkg')
                                            ->columnSpan(2)
                                            ->label('Keterangan Lampu Sein Belakang'),
                                            TextEntry::make('lampu_rem')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }), 
                                            TextEntry::make('ket_lampu_rem')
                                            ->columnSpan(2)
                                            ->label('Keterangan Lampu Rem'),
                                            TextEntry::make('ban_mobil')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }), 
                                            TextEntry::make('ket_ban_mobil')
                                            ->columnSpan(2)
                                            ->label('Keterangan Ban Mobil'),
                                            TextEntry::make('ban_serep')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_ban_serep')
                                            ->columnSpan(2)
                                            ->label('Keterangan Ban Serep'),
                                            TextEntry::make('klakson')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_klakson')
                                            ->columnSpan(2)
                                            ->label('Keterangan Klakson'),
                                            TextEntry::make('wiper')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_wiper')
                                            ->columnSpan(2)
                                            ->label('Keterangan Wiper'),
                                            TextEntry::make('spion')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_spion')
                                            ->columnSpan(2)
                                            ->label('Keterangan Spion'),
                                        ]),
                                    Tabs\Tab::make('Mesin')
                                        ->columns(3)
                                        ->schema([
                                            TextEntry::make('mesin')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_mesin')
                                            ->columnSpan(2)
                                            ->label('Keterangan Mesin'),
                                            TextEntry::make('accu')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_accu')
                                            ->columnSpan(2)
                                            ->label('Keterangan Accu'),
                                            TextEntry::make('rem')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_rem')
                                            ->columnSpan(2)
                                            ->label('Keterangan Rem'),
                                            TextEntry::make('transmisi')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_transmisi')
                                            ->columnSpan(2)
                                            ->label('Keterangan Transmisi'),
                                            TextEntry::make('power_steering')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_power_steering')
                                            ->columnSpan(2)
                                            ->label('Keterangan Power Steering'),
                                            TextEntry::make('radiator')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_radiator')
                                            ->columnSpan(2)
                                            ->label('Keterangan Radiator'),
                                            TextEntry::make('oli_mesin')
                                            ->columnSpan(1)
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'Baik' => 'info',
                                                'Kurang Baik' => 'warning',
                                                'Rusak' => 'danger',
                                            }),
                                            TextEntry::make('ket_oli_mesin')
                                            ->columnSpan(2)
                                            ->label('Keterangan Oli Mesin'),
                                            ]),
                                        ]),
                        ])
                    
                  
                ])->columnSpan(3),
                Group::make([
                    InfolistSection::make('Nilai Survey')
                        ->schema([
                            TextEntry::make('group1_total_value')
                            ->label('Nilai Interior : ')
                            ->size(TextEntry\TextEntrySize::Medium)
                            ->weight(FontWeight::Bold),
                        TextEntry::make('group2_total_value')
                            ->label('Nilai Eksterior : ')
                            ->size(TextEntry\TextEntrySize::Medium)
                            ->weight(FontWeight::Bold),
                        TextEntry::make('group3_total_value')
                            ->label('Nilai Mesin : ')
                            ->size(TextEntry\TextEntrySize::Medium)
                            ->weight(FontWeight::Bold),
                        TextEntry::make('overall_total_value')
                            ->label('Nilai Total :')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight(FontWeight::Bold),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->label('Waktu Pelaksanaan Survey : '),
                        ]),
                    InfolistSection::make('Gambar')
                            ->collapsible()
                            ->collapsed(true)
                            ->schema([
                                ImageEntry::make('gambar_speedometer')
                                ->size(360),
                                ImageEntry::make('gambar_interior')
                                ->size(360),
                                ImageEntry::make('gambar_eksterior')
                                ->size(360),
                                ImageEntry::make('gambar_mesin')
                                ->size(360),
                            ]),
                ])->columnSpan(2),
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
