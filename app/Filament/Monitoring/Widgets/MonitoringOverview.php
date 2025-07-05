<?php
namespace App\Filament\Monitoring\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MonitoringOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        $user_reg = $user->user_reg;
        $nama = $user->nama;
        $total_reseller = $user->resellers->count();
        $total_saldo = $user->resellers->sum('saldo');
        $biaya_sewa = $total_reseller * 25;
        $saldo_deposit = $user->saldo;

        return [
            Stat::make('No Registrasi', $user_reg)
                ->icon('heroicon-o-users'),
            Stat::make('Nama Server', $nama)
                ->icon('heroicon-o-server'),
            Stat::make('Total Reseller', $total_reseller)
                ->icon('heroicon-o-building-storefront'),
            Stat::make('Total Saldo', 'Rp ' . number_format($total_saldo, 0, ',', '.'))
                ->icon('heroicon-o-currency-dollar'),
            Stat::make('Biaya Sewa', 'Rp ' . number_format($biaya_sewa, 0, ',', '.'))
                ->icon('heroicon-o-banknotes'),
            Stat::make('Saldo Deposit', 'Rp ' . number_format($saldo_deposit, 0, ',', '.'))
                ->icon('heroicon-o-credit-card'),
        ];
    }
}
