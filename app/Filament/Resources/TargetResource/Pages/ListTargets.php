<?php

namespace App\Filament\Resources\TargetResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TargetResource;
use Filament\Resources\Pages\ListRecords\Tab;

class ListTargets extends ListRecords
{
    protected static string $resource = TargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()
            // ->label('Buat Target Baru'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Semua' => Tab::make('Semua')
                ->modifyQueryUsing(function (Builder $query) {
                    if (Auth::user()->role === 'admin') {
                        return $query;
                    }
                    // Non-admin users can only view their own component
                    // return 
                        $teamname = Auth::user()->name;
                        $query->where('kecamatan', $teamname);
                    }),
            'Tanah' => Tab::make('Semua Tanah')
                ->modifyQueryUsing(function (Builder $query) {
                    if (Auth::user()->role === 'admin') {
                        return $query->where('kode_barang', 'LIKE', '%1.3.1.%');
                    }
                    // Non-admin users can only view their own component
                    // return 
                        $teamname = Auth::user()->name;
                        $query->where('kecamatan', $teamname)->where('kode_barang', 'LIKE', '%1.3.1.%');;
                    }),
            'Bangunan' => Tab::make('Semua Bangunan')
                ->modifyQueryUsing(function (Builder $query) {
                    if (Auth::user()->role === 'admin') {
                        return $query->where('kode_barang', 'LIKE', '%1.3.3.%');
                    }
                    // Non-admin users can only view their own component
                    // return 
                        $teamname = Auth::user()->name;
                        $query->where('kecamatan', $teamname)->where('kode_barang', 'LIKE', '%1.3.3.%');;
                    }),
            // 'Belum' => Tab::make('Belum')
            //     ->modifyQueryUsing(function (Builder $query) {
            //         if (Auth::user()->role === 'admin') {
            //             return $query->where('user_id', 0);
            //         }
            //         // Non-admin users can only view their own component
            //         // return 
            //             $teamname = Auth::user()->name;
            //             $query->where('kecamatan', $teamname)->where('user_id', 0);
            //         }),
            // 'Selesai' => Tab::make('Selesai')
            //     ->modifyQueryUsing(function (Builder $query) {
            //     if (Auth::user()->role === 'admin') {
            //         return $query->where('user_id','!=', 0);
            //     }
            //     // Non-admin users can only view their own component
            //     // return 
            //         $teamname = Auth::user()->name;
            //         $query->where('kecamatan', $teamname)->where('user_id','!=', 0);
            //     }),
        ];
    }
}
