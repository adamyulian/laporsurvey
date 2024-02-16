<?php

namespace App\Filament\Resources;

use App\Filament\Exports\SurveyExporter;
use Closure;
use Filament\Forms;
use App\Models\Team;
use Filament\Tables;
use App\Models\Detail;
use App\Models\Survey;
use App\Models\Target;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Surveyor;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Rules\AttendanceRadius;
use App\Helpers\LocationHelpers;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Toggle;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Group;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use App\Filament\Resources\SurveyResource\Pages;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Cheesegrits\FilamentGoogleMaps\Commands\Geocode;
use Cheesegrits\FilamentGoogleMaps\Fields\WidgetMap;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use Cheesegrits\FilamentGoogleMaps\Widgets\MapWidget;
use Filament\Forms\Components\Section as formsection;
use App\Filament\Resources\SurveyResource\RelationManagers;
use App\Filament\Resources\SurveyResource\RelationManagers\DetailRelationManager;
use App\Filament\Resources\SurveyResource\RelationManagers\DetailsRelationManager;

class SurveyResource extends Resource
{
    protected static ?string $model = Survey::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $recordTitleAttribute = 'Survey';

    protected static ?string $navigationLabel = 'Survey';

    protected static ?string $navigationGroup = 'Survey Kondisi Aset';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                formsection::make('Informasi Target Survey')
                    ->collapsible()
                    ->columns(4)
                    ->schema([
                        Forms\Components\Select::make('target_id')
                        ->required()
                        ->columnSpan(4)
                        ->label('Silakan memilih Register/Target Survey')
                        ->preload()
                        ->relationship(
                            name: 'Target', 
                            titleAttribute: 'nama',
                            modifyQueryUsing: function (Builder $query) {
                                if (Auth::user()->role === 'admin') {
                                    return $query;
                                }
                        
                                // Non-admin users can only view their own component
                                // return 
                                $teamname = Auth::user()->name;
                                $query->where('kecamatan', $teamname)->where('user_id', 0)
                                ;}
                            )
                        ->getOptionLabelFromRecordUsing(fn (Target $record) => "{$record->register} {$record->nama} {$record->alamat}")
                        ->searchable(['register', 'nama', 'alamat'])
                        ->live(onBlur:true)
                        ->lazy()
                        ->afterStateUpdated(function (string $state, callable $get, Forms\Set $set) {
                            $set('name', Target::find($state)->nama);
                            $set('luas', Target::find($state)->luas);
                            $set('tahun_perolehan', Target::find($state)->tahun_perolehan);
                            $set('penggunaan', Target::find($state)->penggunaan);
                            $set('alamat', Target::find($state)->alamat);
                            $set('kecamatan', Target::find($state)->kecamatan);
                            $set('kelurahan', Target::find($state)->kelurahan);
                            $set('target_id1', Target::find($state)->id);
                            $set('opd', Target::find($state)->opd);
                            $set('sigis', Target::find($state)->sigis);
                            $set('latitude',Target::find($state)->lat);
                            $set('longitude',Target::find($state)->lng);
                            $set('location_target', 
                            [
                                'lat' => floatval(Target::find($state)->lat),
                                'lng' => floatval(Target::find($state)->lng)
                            ]);
                        }),
                        formsection::make('Detail Information')
                            ->collapsible()
                            ->columns(4)
                            ->collapsed(true)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->columnSpan(2)
                                    ->label('Nama')
                                    ->disabled(),
                                Forms\Components\TextInput::make('luas')
                                    ->columnSpan(2)
                                    ->suffix('M2')
                                    ->numeric()
                                    ->disabled(),
                                Forms\Components\TextInput::make('tahun_perolehan')
                                    ->columnSpan(2)
                                    ->disabled(),
                                Forms\Components\TextInput::make('kecamatan')
                                    ->columnSpan(2)
                                    ->disabled(),
                                Forms\Components\TextInput::make('alamat')
                                    ->columnSpan(2)
                                    ->disabled(),
                                Forms\Components\TextInput::make('kelurahan')
                                    ->columnSpan(2)
                                    ->disabled(),
                                Forms\Components\TextInput::make('opd')
                                    ->columnSpan(2)
                                    ->disabled()
                                    ->label('OPD Pengguna'),
                                // Forms\Components\FileUpload::make('sigis')
                                //     ->disabled()
                                //     ->columnSpanFull(),
                                ]),
                            ]),
                formsection::make('Location')
                            ->collapsible()
                            ->collapsed(true)
                            ->schema([
                                Map::make('location_target')
                                    ->columnSpan(2)
                                    ->draggable(false) // Disable dragging to move the marker
                                    ->clickable(false) // Disable clicking to move the marker
                                    ->autocomplete('target_loc') // field on form to use as Places geocompletion field
                                    ->autocompleteReverse(true) // reverse geocode marker location to autocomplete field
                                    ->defaultZoom(15) // Set the initial zoom level to 500
                                    ->reactive()
                                    ->live()
                                    ->lazy(),
                                  
                                Map::make('location')
                                    ->columnSpan(2)
                                    // ->rules([
                                        
                                    //     fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                    //             // The allowed location (latitude and longitude).
                                    //             $allowedLocation = [Target::find($get('target_id'))->lat, Target::find($get('target_id'))->lng];
                                    //             // dd($allowedLocation);
                                    
                                    //             // The radius in meters.
                                    //             $radius = 100;
                                    
                                    //             // Convert the value (user's location) to an array [latitude, longitude].
                                    //             // $userLocation = explode(',', $value);
                                    //             $userLocation = [$get('lat'), $get('lng')];
                                    
                                    //             // Calculate the distance between user and allowed location.
                                    //             $distance = LocationHelpers::haversineDistance($userLocation, $allowedLocation);

                                                                                  
                                    //             // Check if the user is within the specified radius.
                                    //             if ($distance > $radius) {
                                    //                 $fail("The selected location is not within the allowed radius.");
                                    //             }
                                            
                                    //     }])
                                    ->label('Your Location')
                                    ->geolocate() // adds a button to request device location and set map marker accordingly
                                    ->geolocateOnLoad(true, 'always')// Enable geolocation on load for every form
                                    ->draggable(false) // Disable dragging to move the marker
                                    ->clickable(false) // Disable clicking to move the marker
                                    ->defaultZoom(15) // Set the initial zoom level to 500
                                    ->autocomplete('address') // field on form to use as Places geocompletion field
                                    ->autocompleteReverse(true) // reverse geocode marker location to autocomplete field
                                    ->reactive()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        $set('lat', $state['lat']);
                                        $set('lng', $state['lng']);}),
                                        Forms\Components\TextInput::make('latitude'),
                                        Forms\Components\TextInput::make('longitude'),
                                TextInput::make('lat')
                                    ->label('Latitude')
                                    ->readOnly()
                                    ->numeric()
                                    ->columnSpan(1),
                                TextInput::make('lng')
                                    ->label('Longitude')
                                    ->readOnly()
                                    ->numeric()
                                    ->columnSpan(1),
                                TextInput::make('target_loc')
                                    ->label('Target Address')
                                    ->readOnly()
                                    ->columnSpan(2),
                                TextInput::make('address')
                                    ->label('Your Address')
                                    ->readOnly()
                                    ->columnSpan(2),
                                Placeholder::make('distance')
                                        ->label('Jarak Target Lokasi dengan Lokasi Anda (dalam Meter)')
                                        ->columnSpanFull()
                                        ->content(
                                            function ($get) {
                                                if ($get('target_id') === null) {
                                                    return 0;
                                                }
                                                $allowedLocation = [Target::find($get('target_id'))->lat, Target::find($get('target_id'))->lng];
                                                // dd($allowedLocation);
                                    
                                                // The radius in meters.
                                                $radius = 100;
                                    
                                                // Convert the value (user's location) to an array [latitude, longitude].
                                                // $userLocation = explode(',', $value);
                                                $userLocation = [$get('lat'), $get('lng')];
                                    
                                                // Calculate the distance between user and allowed location.
                                                $distance = LocationHelpers::haversineDistance($userLocation, $allowedLocation);

                                                return  $distance;
                                            }
                                        ),
                                ])
                                ->collapsible()
                                ->columns(4),
                                
                formsection::make('Form Survey')
                    ->columns(6)
                    ->schema([
                        // Radio::make('status')
                        //     ->required()
                        //     ->columnSpan(6)
                        //     ->label('Apakah Aset sedang digunakan/dimanfaatkan?')
                        //     ->boolean()
                        //     ->inline()
                        //     ->inlineLabel(false)
                        //     ->live(),
                        // Forms\Components\Select::make('guna')
                        //     ->native(false)
                        //     ->multiple()
                        //     ->options([
                        //         'Rumah Ibadah' => 'Rumah Ibadah',
                        //         'Bisnis/Komersial' => 'Bisnis/Komersial',
                        //         'Fasilitas Umum' => 'Fasilitas Umum',
                        //         'Kantor' => 'Kantor',
                        //         'Ruang Terbuka Hijau' => 'Ruang Terbuka Hijau',
                        //         'Taman' => 'Taman',
                        //         'Rumah Tinggal' => 'Rumah Tinggal',
                        //         'Sekolah' => 'Sekolah',
                        //         'Balai RT/RW' => 'Balai RT/RW',
                        //         'Gedung Serbaguna' => 'Gedung Serbaguna',
                        //         'Tanah Kosong' => 'Tanah Kosong',
                        //         'Jalan' => 'Jalan',
                        //         'Sawah/Kebun' => 'Sawah/Kebun',
                        //         'Tambak' => 'Tambak',
                        //         'Lainnya' => 'Lainnya'
                        //     ])
                        //     ->hidden(fn (Get $get) => $get('status') !== '1')
                        //     ->columnSpan(3)
                        //     ->label('Nama Penggunaan/Pemanfaatan'),
                        // Forms\Components\Textarea::make('detail')
                        //     ->label('Detail Penggunaan/Pemanfaatan')
                        //     ->hidden(fn (Get $get) => $get('status') !== '1')
                        //     ->columnSpan(3)
                        //     ->maxLength(255),
                        // Forms\Components\FileUpload::make('foto')
                        //     ->image()
                        //     ->multiple(10)
                        //     ->preserveFilenames()
                        //     ->label('Foto Bukti (Maks. 10 gambar)')
                        //     ->hidden(fn (Get $get) => $get('status') !== '1')
                        //     ->columnSpan(6)
                        //     ->downloadable(),
                        // Forms\Components\FileUpload::make('foto1')
                        //     ->image()
                        //     ->hidden(fn (Get $get) => $get('status') !== '1')
                        //     ->columnSpan(3)
                        //     ->label('Foto Jalan')
                        //     ->downloadable(),
                        // Forms\Components\FileUpload::make('foto2')
                        //     ->image()
                        //     ->hidden(fn (Get $get) => $get('status') !== '1')
                        //     ->columnSpan(3)
                        //     ->label('Foto Bangunan dengan Jalan')
                        //     ->downloadable(),
                        Forms\Components\FileUpload::make('foto3')
                            ->image()
                            // ->hidden(fn (Get $get) => $get('status') !== '1')
                            ->columnSpan(3)
                            ->label('Foto Bagian Depan')
                            ->downloadable(),
                        Forms\Components\FileUpload::make('foto4')
                            ->image()
                            // ->hidden(fn (Get $get) => $get('status') !== '1')
                            ->columnSpan(3)
                            ->label('Foto Bagian Dalam')
                            ->downloadable(),
                        // Forms\Components\TextInput::make('nama_pic')
                        //     ->label('Nama Pengelola')
                        //     ->hidden(fn (Get $get) => $get('status') !== '1')
                        //     ->columnSpan(3)
                        //     ->maxLength(255),
                        // Forms\Components\TextInput::make('no_hp_pic')
                        //     ->label('Nomor Telepon/Whatsapp Pengelola')
                        //     ->tel()
                        //     ->numeric()
                        //     ->hidden(fn (Get $get) => $get('status') !== '1')
                        //     ->columnSpan(3)
                        //     ->maxLength(255),
                        // Forms\Components\Select::make('hubungan_hukum')
                        //     ->options([
                        //         'belum' => 'Belum Pernah Membuat Hubungan Hukum',
                        //         'sudah_habis' => 'Masa Berlaku Hubungan Hukum Habis',
                        //         'ada' => 'Dokumen Hubungan Hukum Masih Berlaku',
                        //     ])
                        //     ->hidden(fn (Get $get) => $get('status') !== '1')
                        //     ->live()
                        //     ->columnSpan(3)
                        //     ->native(false),
                        // Forms\Components\FileUpload::make('dokumen_hub_hukum')
                        //     ->hidden(fn (Get $get) => !in_array($get('hubungan_hukum'), ['sudah_habis', 'ada']))
                        //     ->columnSpan(3), 
                        // Forms\Components\Select::make('surveyor')
                        // ->relationship(
                        //     name: 'surveyor',
                        //     titleAttribute: 'nama',

                        //     modifyQueryUsing: function (Builder $query) {

                        //         if (Auth::user()->role === 'admin') {
                        //             return $query;
                        //         }
                        //         $teamname = Auth::user()->team->id;
                        //         $query->where('team_id', $teamname)
                        //         ;}
                        // )
                        // ->native(false)
                        // ->multiple()
                        // ->columnSpanFull()
                        // ->preload()
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
                //return 
                    $teamId = Auth::user()->id;
                    $query->where('user_id', $teamId);
                })
            ->defaultSort(column:'created_at', direction:'desc')
            ->columns([
                Tables\Columns\TextColumn::make('target.register')
                    ->description(fn (Survey $record): string => $record->target->nama)
                    ->limit(25)
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                // Tables\Columns\TextColumn::make('user.name')
                //     ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->alignCenter()
                    ->label('Digunakan/Dimanfaatkan')
                    ->boolean(),
                Tables\Columns\TextColumn::make('details')
                    ->state(function (Survey $record): float {
                        $details = Detail::where('survey_id', $record->id)->count();
                        return $details;
                    })
                    ->label('Jumlah Detail')
                    ->alignCenter()
                    ->badge(),
                Tables\Columns\TextColumn::make('guna')
                    ->label('Digunakan sebagai')
                    ->searchable()
                    ->wrap(),
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('surveyor.nama')
                    ->listWithLineBreaks()
                    ->limitList(3)
                    ->label('Surveyor')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\ImageColumn::make('dokumen_hub_hukum')
                //     ->label('Dok. Hukum')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Survey')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('team.name')
                    ->label('Nama Team')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('team_id')
                        ->label('Group')
                        ->native(false)
                        ->options(fn (): array => Team::query()->pluck('name', 'id')->all())
                ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(SurveyExporter::class)
                    ->label('Download Data')
                    ->color('info')
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
                        TextEntry::make('target.opd')
                            ->columnSpan(2)
                            ->label('OPD Pengguna Barang'),
                        TextEntry::make('target.kecamatan')
                            ->columnSpan(2)
                            ->label('Kecamatan'),
                        TextEntry::make('target.kelurahan')
                            ->columnSpan(2)
                            ->label('Kelurahan'),
                        TextEntry::make('target.tahun_perolehan')
                            ->columnSpan(2)
                            ->label('Tahun Perolehan'),  
                        TextEntry::make('target.luas')
                            ->columnSpan(2)
                            ->label('Luas Tanah/Bangunan'),
                        TextEntry::make('Luas Total Penggunaan')
                            ->label('Luas Total Penggunaan')
                            ->columnSpan(2)
                            ->state(function (Survey $record): float {
                                $subtotal = 0;
                                $detailcostsubtasks = Detail::select('*')->where('survey_id', $record->id)->get();
                                foreach ($detailcostsubtasks as $key => $rincian){
                                    $luas = $rincian->luas;
                                    $subtotal+=$luas;
                                }
                                return $subtotal;
                            }),
                        TextEntry::make('target.alamat')
                            ->columnSpan(2)
                            ->label('Alamat'),
                    ]),
                    Section::make('Hasil Survey')
                        ->columns(4)
                        ->schema([
                            // IconEntry::make('status')
                            //     ->columnSpan(4)
                            //     ->label('Aset dalam Penggunaan/Pemanfaatan')
                            //     ->inlineLabel()
                            //     ->boolean()
                            //     ->trueIcon('heroicon-o-check-badge')
                            //     ->falseIcon('heroicon-o-x-mark'),
                            // TextEntry::make('guna')
                            //     ->columnSpan(2)
                            //     ->label('Nama Penggunaan/Pemanfaatan'),
                            // TextEntry::make('detail')
                            //     ->columnSpan(2)
                            //     ->label('Detail Penggunaan/Pemanfaatan'),
                            // ImageEntry::make('foto')
                            //     ->columnSpan(4)
                            //     ->limit(5)
                            //     ->limitedRemainingText()
                            //     ->label('Foto Bukti Penggunaan/Pemanfaatan')
                            //     ->size(150),
                            // ImageEntry::make('foto1')
                            //     ->columnSpan(2)
                            //     ->label('Foto Jalan Akses'),
                            // ImageEntry::make('foto2')
                            //     ->columnSpan(2)
                            //     ->label('Foto Bangunan dan Jalan'),
                            ImageEntry::make('foto3')
                            ->columnSpan(2)
                                ->label('Foto Bagian Luar'),
                            ImageEntry::make('foto4')
                            ->columnSpan(2)    
                            ->label('Foto Bagian Dalam'),
                            // TextEntry::make('nama_pic')
                            //     ->columnSpan(2)
                            //     ->label('Nama Penanggung Jawab'),
                            // TextEntry::make('no_hp_pic')
                            //     ->columnSpan(2)
                            //     ->label('Nomor Telepon/Whatsapp Penanggung Jawab'),
                            // TextEntry::make('hubungan_hukum')
                            //     ->columnSpan(2)
                            //     ->badge()
                            //     ->color(fn (string $state): string => match ($state) {
                            //         'belum' => 'danger',
                            //         'sudah_habis' => 'warning',
                            //         'ada' => 'success',})
                            //     ->label('Hubungan Hukum'),
                            // ImageEntry::make('dokumen_hub_hukum')
                            //     ->columnSpan(2)
                            //     ->label('Dokumen Hub. Hukum'),
                            
                        ])
                ])->columnSpan(4),
                Group::make([
                    Section::make([
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('published_at')
                            ->dateTime(),
                        TextEntry::make('lat'),
                        TextEntry::make('lng'),
                        TextEntry::make('address')
                                ->label('Location Data Saved'),
                        // TextEntry::make('surveyor.nama')
                        //         ->label('Surveyor')
                    ])
                ])->columnSpan(1)
            ])->columns(5);
    }

    public static function getRelations(): array
    {
        return [
            DetailRelationManager::class,
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
