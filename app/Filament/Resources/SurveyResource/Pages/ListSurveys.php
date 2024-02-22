<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SurveyResource;
use App\Models\Survey;
use Filament\Resources\Pages\ListRecords\Tab;

class ListSurveys extends ListRecords
{
    protected static string $resource = SurveyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Semua' => Tab::make('Semua')
                ->modifyqueryUsing(function (Survey $survey) {
                    if (Auth::user()->role === 'admin') {
                        return $survey;
                    }
                    // Non-admin users can only view their own component
                    // return 
                        $teamname = Auth::user()->name;
                        $survey->where('kecamatan', $teamname);
                    }),
            'Tanah' => Tab::make('Semua Tanah')
                ->modifyqueryUsing(function (Survey $survey) {
                    if (Auth::user()->role === 'admin') {
                        return $survey  
                                // ->where('kode_barang', 'LIKE', '%1.3.1.%')        
                                ->where('target.nama', 'LIKE', '%Tanah Tambak%');
                    }
                    // Non-admin users can only view their own component
                    // return 
                        $teamname = Auth::user()->name;
                        $survey->where('kecamatan', $teamname)->where('survey.target.kode_barang', 'LIKE', '%1.3.1.%');;
                    }),
            'Bangunan' => Tab::make('Semua Bangunan')
                ->modifyqueryUsing(function (Survey $survey) {
                    if (Auth::user()->role === 'admin') {
                        return $survey->where('target.kode_barang', 'LIKE', '%1.3.3.%');
                    }
                    // Non-admin users can only view their own component
                    // return 
                        $teamname = Auth::user()->name;
                        $survey->where('kecamatan', $teamname)->where('target.kode_barang', 'LIKE', '%1.3.3.%');;
                    }),
        ];
    }
}
