<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Survey;
use App\Models\Target;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Toggle;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Model;
use Filament\Infolists\Components\Group;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\SurveyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section as formsection;
use App\Filament\Resources\SurveyResource\RelationManagers;

class SurveyResource extends Resource
{
    protected static ?string $model = Survey::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'Survey';

    protected static ?string $navigationLabel = 'Survey';

    protected static ?string $navigationGroup = 'Pelaksanaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                formsection::make('Informasi Target Survey')
                    ->columns(4)
                    ->schema([
                        Forms\Components\Select::make('target_id')
                        ->columnSpan(4)
                        ->relationship(
                            name: 'Target', 
                            titleAttribute: 'nama',
                            modifyQueryUsing: function (Builder $query) {
                                $teamname = Auth::user()->team->name;
                                $query->where('surveyor', $teamname)->where('user_id', null);}
                            )
                        ->getOptionLabelFromRecordUsing(fn (Target $record) => "{$record->register} {$record->nama} {$record->alamat}")
                        ->searchable(['register', 'nama', 'alamat'])
                        ->live(onBlur:true)
                        ->afterStateUpdated(function (string $state, Forms\Set $set) {
                            $set('name', Target::find($state)->nama);
                            $set('luas', Target::find($state)->luas);
                            $set('tahun_perolehan', Target::find($state)->tahun_perolehan);
                            $set('penggunaan', Target::find($state)->penggunaan);
                            $set('alamat', Target::find($state)->alamat);
                            $set('asal', Target::find($state)->asal);
                            // $set('hargaunit', CostComponent::find($state)->hargaunit);
                            // $set('brand', CostComponent::find($state)->brand->nama);
                        }),
                        Forms\Components\TextInput::make('name')
                            ->columnSpan(1)
                            ->label('Nama')
                            ->disabled(),
                        Forms\Components\TextInput::make('luas')
                            ->columnSpan(1)
                            ->suffix('M2')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('tahun_perolehan')
                            ->columnSpan(1)
                            ->disabled(),
                        Forms\Components\TextInput::make('penggunaan')
                            ->columnSpan(1)
                            ->disabled(),
                        Forms\Components\TextInput::make('alamat')
                            ->columnSpan(2)
                            ->disabled(),
                        Forms\Components\TextInput::make('asal')
                            ->columnSpan(2)
                            ->disabled(),
                        ]),
                formsection::make('Form Survey')
                    ->columns(5)
                    ->schema([
                        Radio::make('status')
                            ->columnSpan(5)
                            ->label('Apakah Aset sedang digunakan/dimanfaatkan?')
                            ->boolean()
                            ->inline()
                            ->inlineLabel(false)
                            ->live(),
                        Forms\Components\Select::make('nama')
                            ->native(false)
                            ->options([
                                'Rumah Ibadah' => 'Rumah Ibadah',
                                'Bisnis/Komersial' => 'Bisnis/Komersial',
                                'Fasilitas Umum' => 'Fasilitas Umum',
                                'Kantor' => 'Kantor',
                                'Ruang Terbuka Hijau' => 'Ruang Terbuka Hijau',
                                'Taman' => 'Taman'
                            ])
                            ->hidden(fn (Get $get) => $get('status') !== '1')
                            ->columnSpan(2)
                            ->label('Nama Penggunaan/Pemanfaatan'),
                        Forms\Components\Textarea::make('detail')
                            ->label('Detail Penggunaan/Pemanfaatan')
                            ->hidden(fn (Get $get) => $get('status') !== '1')
                            ->columnSpan(3)
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('foto')
                            ->label('Foto Bukti Penggunaan/Pemanfaatan')
                            ->hidden(fn (Get $get) => $get('status') !== '1')
                            ->columnSpan(5)
                            ->multiple()
                            ->maxFiles(5)
                            ->label('Foto Bukti Penggunaan/Pemanfaatan')
                            ->downloadable(),
                        Forms\Components\TextInput::make('nama_pic')
                            ->label('Nama Penanggung Jawab')
                            ->hidden(fn (Get $get) => $get('status') !== '1')
                            ->columnSpan(3)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('no_hp_pic')
                            ->label('Nomor Telepon/Whatsapp Penanggung Jawab')
                            ->tel()
                            ->numeric()
                            ->hidden(fn (Get $get) => $get('status') !== '1')
                            ->columnSpan(2)
                            ->maxLength(255),
                        Forms\Components\Select::make('hubungan_hukum')
                            ->options([
                                'belum' => 'Belum Pernah Membuat Hubungan Hukum',
                                'sudah_habis' => 'Masa Berlaku Hubungan Hukum Habis',
                                'ada' => 'Dokumen Hubungan Hukum Masih Berlaku',
                            ])
                            ->hidden(fn (Get $get) => $get('status') !== '1')
                            ->live()
                            ->columnSpan(3)
                            ->native(false),
                        Forms\Components\FileUpload::make('dokumen_hub_hukum')
                            ->hidden(fn (Get $get) => !in_array($get('hubungan_hukum'), ['sudah_habis', 'ada']))
                            ->columnSpan(2), 
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->modifyQueryUsing(function (Builder $query) {
            //         $teamname = Auth::user()->team->name;
            //         $query->where('user_id', $teamname);
            //     })
            ->columns([
                Tables\Columns\TextColumn::make('target.nama')
                    ->description(fn (Survey $record): string => $record->target->register)
                    ->limit(25)
                    ->sortable(),
                // Tables\Columns\TextColumn::make('user.name')
                //     ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->alignCenter()
                    ->label('Digunakan/Dimanfaatkan')
                    ->boolean(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('digunakan sebagai')
                    ->searchable(),
                // Tables\Columns\ImageColumn::make('foto')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('nama_pic')
                //     ->description(fn (Survey $record): string => $record->no_hp_pic)
                //     ->label('PIC')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('no_hp_pic')
                //     ->label('No PIC')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('hubungan_hukum')
                    ->label('Hub. Hukum')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'belum' => 'danger',
                        'sudah_habis' => 'warning',
                        'ada' => 'success',})
                    ->searchable(),
                // Tables\Columns\ImageColumn::make('dokumen_hub_hukum')
                //     ->label('Dok. Hukum')
                //     ->searchable(),
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
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function infolist(Infolist $infolist): Infolist

    {
        return $infolist
            ->schema([
                Group::make([
                    Section::make('Informasi Register')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('target.nama')
                            ->columnSpan(2)
                            ->label('Nama Register')
                            ->weight(FontWeight::Bold)
                            ->size(TextEntry\TextEntrySize::Large),
                        TextEntry::make('target.register')
                            ->columnSpan(2)
                            ->label('Nomor Register'),
                        TextEntry::make('target.penggunaan')
                            ->columnSpan(2)
                            ->label('Penggunaan'),
                        TextEntry::make('target.luas')
                            ->columnSpan(1)
                            ->label('Luas Tanah/Bangunan'),
                        TextEntry::make('target.tahun_perolehan')
                            ->columnSpan(1)
                            ->label('Tahun Perolehan'),  
                        TextEntry::make('target.alamat')
                            ->columnSpan(2)
                            ->label('Alamat'),
                        TextEntry::make('target.asal')
                            ->columnSpan(2)
                            ->label('Asal Perolehan'),
                    ]),
                    Section::make('Hasil Survey')
                        ->columns(4)
                        ->schema([
                            IconEntry::make('status')
                                ->columnSpan(4)
                                ->label('Aset dalam Penggunaan/Pemanfaatan')
                                ->inlineLabel()
                                ->boolean()
                                ->trueIcon('heroicon-o-check-badge')
                                ->falseIcon('heroicon-o-x-mark'),
                            TextEntry::make('nama')
                                ->columnSpan(2)
                                ->label('Nama Penggunaan/Pemanfaatan'),
                            TextEntry::make('detail')
                                ->columnSpan(2)
                                ->label('Detail Penggunaan/Pemanfaatan'),
                            ImageEntry::make('foto')
                                ->columnSpan(4)
                                ->label('Foto Bukti Penggunaan/Pemanfaatan')
                                ->height(100)
                                ->ring(5)
                                ->circular()
                                ->overlap(5)
                                ->limit(2)
                                ->limitedRemainingText(isSeparate: true, size: 'lg')
                                ->stacked()
                                ->grow(false),
                            TextEntry::make('nama_pic')
                                ->columnSpan(2)
                                ->label('Nama Penanggung Jawab'),
                            TextEntry::make('no_hp_pic')
                                ->columnSpan(2)
                                ->label('Nomor Telepon/Whatsapp Penanggung Jawab'),
                            TextEntry::make('hubungan_hukum')
                                ->columnSpan(2)
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'belum' => 'danger',
                                    'sudah_habis' => 'warning',
                                    'ada' => 'success',})
                                ->label('Hubungan Hukum'),
                            ImageEntry::make('dokumen_hub_hukum')
                                ->columnSpan(2)
                                ->label('Dokumen Hub. Hukum'),
                            
                        ])
                ])->columnSpan(4),
                Group::make([
                    Section::make([
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
            'index' => Pages\ListSurveys::route('/'),
            'create' => Pages\CreateSurvey::route('/create'),
            'view' => Pages\ViewSurvey::route('/{record}'),
            'edit' => Pages\EditSurvey::route('/{record}/edit'),
        ];
    }    
}
