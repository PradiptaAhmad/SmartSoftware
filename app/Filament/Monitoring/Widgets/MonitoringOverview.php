<?php

namespace App\Filament\Monitoring\Widgets;

use App\Services\ApiService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MonitoringOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = $this->getUserData();
        $resellers = $this->getResellersData();

        $user_reg = $user['id'];
        $nama = $user['user_reg'];
        $total_reseller = $resellers->count();
        $total_saldo = $resellers->sum('saldo');
        $biaya_sewa = $total_reseller * 25;

        $saldo_deposit = $user['saldo'];

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

    public function getUserData()
    {
        $apiService = new ApiService();
        $response = $apiService->get(
            endpoint: '/profile',
            authToken: auth()->user()->auth_token,
        );
        if ($response->successful()) {
            return collect(
                value: $response->json()
            );
        }
        return collect([]);
    }

    public function getResellersData()
    {
        $apiService = new ApiService();
        $response = $apiService->get(
            endpoint: '/r',
            authToken: auth()->user()->auth_token,
        );
        if ($response->successful()) {
            return collect(
                value: $response->json()
            );
        }
        return collect([]);
    }
}
