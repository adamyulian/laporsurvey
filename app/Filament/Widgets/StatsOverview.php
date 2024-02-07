<?php

namespace App\Filament\Widgets;

use App\Models\Survey;
use App\Models\Target;
use Filament\Infolists\Components\Section;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()->role === 'admin';
    }
    
    protected function getStats(): array
    {
        $userId = Auth::id();
        $user = auth()->user();

        if ($user && ($user->role === 'admin')) {
            // Admin gets all data
            return [
                Section::make('Survey Aset Tanah')
                ->schema([
                    Stat::make('Total Target Aset Tanah', Target::count()),
                    Stat::make('Total Survey Aset Tanah', Survey::count()),
                    Stat::make('Sisa Target Survey', Target::where('user_id',0)->count()),
                    Stat::make('Total Survey Group 1', Survey::where('team_id', 1)->count()),
                    Stat::make('Total Survey Group 2', Survey::where('team_id', 2)->count()),
                    Stat::make('Total Survey Group 3', Survey::where('team_id', 3)->count()),
                    Stat::make('Total Survey Group 4', Survey::where('team_id', 4)->count()),
                ])
                
               
            ];
        } elseif ($user->role === 'ketua') {
            // Regular user gets data based on their ID
            $teamId = $user->team->id;
            $teamName = $user->team->name;
        
            return [
                Stat::make('Total Target', Target::where('surveyor', $teamName)->count()),
                Stat::make('Total Survey', Survey::where('team_id', $teamId)->count()),
                Stat::make('Sisa Target Survey', Target::where('surveyor', $teamName)->where('user_id',0)->count()),
            ];
        } 
        else {
            $userId = $user->id;

                return [
                Stat::make('Total Target', Target::where('user_id', $userId)->count()),
                Stat::make('Total Survey', Survey::where('user_id', $userId)->count()),
                // Stat::make('Sisa Target Survey', Target::where('user_id', $userId)->where('user_id',0)->count()),
            ];
        }
    }
}
