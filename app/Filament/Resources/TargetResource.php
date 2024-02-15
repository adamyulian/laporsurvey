<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Target;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\Group;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use App\Filament\Resources\TargetResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use App\Filament\Resources\TargetResource\RelationManagers;
use Filament\Infolists\Components\Section as InfolistSection;

class TargetResource extends Resource
{
    protected static ?string $model = Target::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-americas';

    protected static ?string $navigationLabel = 'Target Tanah';

    protected static ?string $navigationGroup = 'Pemanfaatan Aset Tanah';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Information')
                    ->schema([
                    Forms\Components\TextInput::make('nama')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('register')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('luas')
                        ->suffix('M2'),
                    Forms\Components\TextInput::make('penggunaan')
                        // ->native(false)
                        // ->multiple()
                        // ->options([
                        //             'Rumah Ibadah' => 'Rumah Ibadah',
                        //             'Bisnis/Komersial' => 'Bisnis/Komersial',
                        //             'Fasilitas Umum' => 'Fasilitas Umum',
                        //             'Kantor' => 'Kantor',
                        //             'Ruang Terbuka Hijau' => 'Ruang Terbuka Hijau',
                        //             'Taman' => 'Taman',
                        //             'Rumah Tinggal' => 'Rumah Tinggal',
                        //             'Sekolah' => 'Sekolah',
                        //             'Balai RT/RW' => 'Balai RT/RW',
                        //             'Gedung Serbaguna' => 'Gedung Serbaguna',
                        //             'Tanah Kosong' => 'Tanah Kosong',
                        //             'Lainnya' => 'Lainnya'
                        // ])
                            ->label('Nama Penggunaan/Pemanfaatan'),
                    Forms\Components\TextInput::make('tahun_perolehan')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('alamat')
                        ->maxLength(255),
                    // Forms\Components\TextInput::make('penggunaan')
                    //     ->maxLength(255),
                    Forms\Components\TextInput::make('asal')
                        ->maxLength(255),
                    Forms\Components\FileUpload::make('sigis')
                        ->image()
                        ->label('Gambar Sigis'),
                    Forms\Components\Select::make('surveyor')
                        ->options([
                            'Group 1' => 'Group 1',
                            'Group 2' => 'Group 2',
                            'Group 3' => 'Group 3',
                            'Group 4' => 'Group 4'
                        ]),
                        
                    ]),
                    Section::make('Location')
                        ->collapsible()
                        ->collapsed(true)
                        ->schema([
                            Map::make('location_target')
                            ->reactive()
                            ->live()
                            ->lazy()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $set('latitude', $state['lat']);
                                $set('longitude', $state['lng']);
                            }),
                            Forms\Components\TextInput::make('lat'),
                            Forms\Components\TextInput::make('lng'),
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
                    $teamname = Auth::user()->name;
                    $query->where('opd', $teamname);
                })
            ->columns([
                Tables\Columns\TextColumn::make('register')
                    ->description(fn (Target $record): string => $record->nama)
                    ->limit(25)
                    ->searchable(),
                Tables\Columns\TextColumn::make('luas')
                    ->suffix(' M2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penggunaan')
                    ->limit(15)
                    ->description(fn (Target $record): string => $record->alamat)
                    ->searchable(),
                Tables\Columns\TextColumn::make('asal')
                    ->description(fn (Target $record): string => $record->tahun_perolehan)
                    ->label('Asal dan Tahun Perolehan')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('surveyor')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    // MapColumn::make('location_target')
                    // // ->extraAttributes([
                    // //   'class' => 'my-funky-class'
                    // // ]) // Optionally set any additional attributes, merged into the wrapper div around the image tag
                    // // ->extraImgAttributes(
                    // //     fn ($record): array => ['title' => $record->latitude . ',' . $record->longitude]
                    // // ) // Optionally set any additional attributes you want on the img tag
                    // ->height('150') // API setting for map height in PX
                    // ->width('250') // API setting got map width in PX
                    // ->type('hybrid') // API setting for map type (hybrid, satellite, roadmap, tarrain)
                    // ->zoom(15) // API setting for zoom (1 through 20)
                    // ->ttl(60 * 60 * 24 * 30), // number of seconds to cache image before refetching from API
                // Tables\Columns\TextColumn::make('user_id')
                //     ->numeric()
                //     ->sortable(),
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
                    InfolistSection::make('Informasi Register')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('nama')
                            ->columnSpan(2)
                            ->label('Nama Register')
                            ->weight(FontWeight::Bold)
                            ->size(TextEntry\TextEntrySize::Large),
                        TextEntry::make('register')
                            ->columnSpan(2)
                            ->label('Nomor Register'),
                        TextEntry::make('penggunaan')
                            ->columnSpan(2)
                            ->label('Penggunaan'),
                        TextEntry::make('luas')
                            ->columnSpan(1)
                            ->label('Luas Tanah/Bangunan'),
                        TextEntry::make('tahun_perolehan')
                            ->columnSpan(1)
                            ->label('Tahun Perolehan'),  
                        TextEntry::make('alamat')
                            ->columnSpan(2)
                            ->label('Alamat'),
                        TextEntry::make('asal')
                            ->columnSpan(2)
                            ->label('Asal Perolehan'),
                        ImageEntry::make('sigis')
                            ->label('Gambar SIGIS')
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
                                ->label('Location'),
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
            'index' => Pages\ListTargets::route('/'),
            'create' => Pages\CreateTarget::route('/create'),
            'view' => Pages\ViewTarget::route('/{record}'),
            'edit' => Pages\EditTarget::route('/{record}/edit'),
        ];
    }    
}
