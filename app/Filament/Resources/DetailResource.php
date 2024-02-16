<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Detail;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DetailResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DetailResource\RelationManagers;

class DetailResource extends Resource
{
    protected static ?string $model = Detail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Kondisi Aset Tanah';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('survey_id')
                    ->numeric(),
                Forms\Components\TextInput::make('penggunaan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('luas')
                    ->numeric(),
                Forms\Components\TextInput::make('detail')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kondisi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('foto_penggunaan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('hub_hukum')
                    ->maxLength(255),
                Forms\Components\TextInput::make('id_penggunaan')
                    ->maxLength(255),
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
            ->defaultGroup('survey.target.register')
            ->columns([
                Tables\Columns\TextColumn::make('id_penggunaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penggunaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('luas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('detail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kondisi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foto_penggunaan')
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
