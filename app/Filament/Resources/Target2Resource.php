<?php

namespace App\Filament\Resources;

use App\Filament\Exports\Target2Exporter;
use Filament\Forms;
use Filament\Tables;
use App\Models\Target2;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Target2Resource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Target2Resource\RelationManagers;

class Target2Resource extends Resource
{
    protected static ?string $model = Target2::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Target Kendaraan';

    protected static ?string $recordTitleAttribute = 'Target';

    protected static ?string $navigationGroup = 'Kondisi Aset Kendaraan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nopol')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahun')
                    ->maxLength(255),
                Forms\Components\TextInput::make('merk')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tipe')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jabatan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('opd')
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
            // return 
                $name = Auth::user()->name;
                $query->where('nama_penyelia', $name);
            })
            ->columns([
                Tables\Columns\TextColumn::make('nopol')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun')
                    ->searchable(),
                Tables\Columns\TextColumn::make('merk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipe')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan')
                    ->description(fn (Target2 $record): string => $record->opd)
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_penyelia')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable()
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
                ->label('Buat Target Baru'),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(Target2Exporter::class)
                    ->label('Download Data')
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
            'index' => Pages\ListTarget2s::route('/'),
            'create' => Pages\CreateTarget2::route('/create'),
            'view' => Pages\ViewTarget2::route('/{record}'),
            'edit' => Pages\EditTarget2::route('/{record}/edit'),
        ];
    }    
}
