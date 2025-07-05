<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Resources\UserResource\Pages\ListUsers;

class UserOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage()
    {
        return ListUsers::class;
    }

    protected function getStats(): array
    {
        $user = User::all();
        $total_user = $user->count();
        $user_aktif = $user->where('aktif', true)->count();
        $user_non_aktif = $user->where('aktif', false)->count();

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
