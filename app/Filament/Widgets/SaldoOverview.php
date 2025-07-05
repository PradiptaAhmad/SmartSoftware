<?php

namespace App\Filament\Widgets;

use App\Models\Reseller;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SaldoOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $total_saldo_user = User::sum('saldo');
        $total_saldo_user = 'Rp ' . number_format($total_saldo_user, 0, ',', '.');

        // $total_saldo_reseller = Reseller::sum('saldo');
        // $total_saldo_reseller = 'Rp ' . number_format($total_saldo_reseller, 0, ',', '.');


        return [
            Stat::make('Total Saldo User', $total_saldo_user)
                ->description('Jumlah total saldo user')
                ->color('primary')
                ->icon('heroicon-o-users'),
            // Stat::make('Total Saldo Reseller', $total_saldo_reseller)
            //     ->description('Jumlah total saldo reseller')
            //     ->color('success')
            //     ->icon('heroicon-o-banknotes'),
        ];
    }
}
