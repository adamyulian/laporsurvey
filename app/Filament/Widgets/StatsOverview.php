<?php

namespace App\Filament\Widgets;

use App\Models\Survey;
use App\Models\Target;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // $userId = Auth::id();
        // $user = auth()->user();

        // if ($user && $user->id === 1) {
        //     // Admin gets all data
        return [
            Stat::make('Total Target', Target::count()),
            Stat::make('Total Survey', Survey::count()),
        ];
    // } else {
    //     // Regular user gets data based on their ID
    //     $userId = $user->id;

    //     return [
    //         Stat::make('Total Target', Target::where('user_id', $userId)->count()),
    //         Stat::make('Total Survey', Survey::where('user_id', $userId)->count()),
    //     ];
    // }
    }
}
