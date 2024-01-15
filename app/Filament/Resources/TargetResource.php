<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Target;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use App\Filament\Resources\TargetResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Cheesegrits\FilamentGoogleMaps\Columns\MapColumn;
use App\Filament\Resources\TargetResource\RelationManagers;

class TargetResource extends Resource
{
    protected static ?string $model = Target::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Target Aset';

    protected static ?string $navigationGroup = 'Pelaksanaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->maxLength(255),
                Forms\Components\TextInput::make('register')
                    ->maxLength(255),
                Forms\Components\TextInput::make('luas')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahun_perolehan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->maxLength(255),
                Forms\Components\TextInput::make('penggunaan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('asal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('surveyor')
                    ->maxLength(255),
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

                // Forms\Components\TextInput::make('user_id')
                //     ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                    $teamname = Auth::user()->team->name;
                    $query->where('surveyor', $teamname);
                })
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('register')
                    ->searchable(),
                Tables\Columns\TextColumn::make('luas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_perolehan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penggunaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asal')
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
                    MapColumn::make('location_target')
                    // ->extraAttributes([
                    //   'class' => 'my-funky-class'
                    // ]) // Optionally set any additional attributes, merged into the wrapper div around the image tag
                    // ->extraImgAttributes(
                    //     fn ($record): array => ['title' => $record->latitude . ',' . $record->longitude]
                    // ) // Optionally set any additional attributes you want on the img tag
                    ->height('150') // API setting for map height in PX
                    ->width('250') // API setting got map width in PX
                    ->type('hybrid') // API setting for map type (hybrid, satellite, roadmap, tarrain)
                    ->zoom(15) // API setting for zoom (1 through 20)
                    ->ttl(60 * 60 * 24 * 30), // number of seconds to cache image before refetching from API
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
