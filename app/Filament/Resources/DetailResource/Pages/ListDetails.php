<?php

namespace App\Filament\Resources\DetailResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DetailResource;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Support\Facades\DB;

class ListDetails extends ListRecords
{
    protected static string $resource = DetailResource::class;

    protected ?string $heading = 'Detail Penggunaan';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
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
            'Yang' => Tab::make('Ada Data Bangunan')
                ->modifyQueryUsing(function (Builder $query) {
                    if (Auth::user()->role === 'admin') {
                        return $query->select('details.*', 'targets.register')
                        ->join('surveys', 'details.survey_id', '=', 'surveys.id')
                        ->join('targets', 'surveys.target_id', '=', 'targets.id')
                        ->whereExists(function ($query) {
                            $query->select(DB::raw(1))
                                ->from('databangunans')
                                ->whereColumn('databangunans.register_tanah', '=', 'targets.register');
                        });
                    }
                    // Non-admin users can only view their own component
                    // return
                        $teamname = Auth::user()->name;
                        $query->where('kecamatan', $teamname);
                    }),
        ];
    }
}
