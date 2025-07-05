<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardOverview extends BaseWidget
{
    // protected int|string|array $columnSpan = 15;
    protected function getStats(): array
    {
        $user = User::all();
        $total_user = $user->count();
        $user_aktif = $user->where('status', true)->count();
        $user_non_aktif = $user->where('status', false)->count();

        return [
            Stat::make('Total User', $total_user)
                ->description('Jumlah total user terdaftar')
                ->color('primary')
                ->icon('heroicon-o-users'),
            Stat::make('User Aktif', $user_aktif)
                ->color('success')
                ->description('Jumlah user yang aktif')
                ->icon('heroicon-o-check-circle'),
            Stat::make('User Non Aktif', $user_non_aktif)
                ->color('danger')
                ->description('Jumlah user yang tidak aktif')
                ->icon('heroicon-o-x-circle'),
        ];
    }
}
