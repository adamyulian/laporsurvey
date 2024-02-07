<?php

namespace App\Filament\Resources\Target2Resource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Target2Resource;
use Filament\Resources\Pages\ListRecords\Tab;

class ListTarget2s extends ListRecords
{
    protected static string $resource = Target2Resource::class;

    protected ?string $heading = 'List Target';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Buat Target Baru'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make('All Target')
                ->modifyQueryUsing(function (Builder $query) {
                    if (Auth::user()->role === 'admin') {
                        return $query;
                    }
                    // Non-admin users can only view their own component
                    // return 
                        $nameUser = Auth::user()->name;
                        $query->where('nama_penyelia', $nameUser)
                        ->where('status', 0);
                    }),
            'Belum' => Tab::make('Belum')
                ->modifyQueryUsing(function (Builder $query) {
                    if (Auth::user()->role === 'admin') {
                        return $query->where('status', 0);
                    }
                    // Non-admin users can only view their own component
                    // return 
                        $userName = Auth::user()->name;
                        $query->where('nama_penyelia', $userName)->where('status', 0);
                    }),
            'Selesai' => Tab::make('Selesai')
                ->modifyQueryUsing(function (Builder $query) {
                if (Auth::user()->role === 'admin') {
                    return $query->where('status','!=', 0);
                }
                // Non-admin users can only view their own component
                // return 
                    $userName = Auth::user()->name;
                    $query->where('nama_penyelia', $userName)->where('status','!=', 0);
                }),
        ];
    }
}
