<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Reseller;
use App\Services\ApiService;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SaldoOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $apiService = new ApiService();
        $customers = collect(
            value: $apiService->get(
                endpoint: '/c',
                authToken: auth()->user()->auth_token,
            )->json()
        );
        $customers_balance = $customers->sum('saldo');
        $customers_balance = 'Rp ' . number_format($customers_balance, 0, ',', '.');

        // $total_saldo_reseller = Reseller::sum('saldo');
        // $total_saldo_reseller = 'Rp ' . number_format($total_saldo_reseller, 0, ',', '.');


        return [
            Stat::make('Total Saldo Customer', $customers_balance)
                ->description('Jumlah total saldo customer')
                ->color('primary')
                ->icon('heroicon-o-users'),
            // Stat::make('Total Saldo Reseller', $total_saldo_reseller)
            //     ->description('Jumlah total saldo reseller')
            //     ->color('success')
            //     ->icon('heroicon-o-banknotes'),
        ];
    }
}
