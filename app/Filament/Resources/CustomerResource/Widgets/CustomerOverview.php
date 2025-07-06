<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Resources\CustomerResource\Pages\ListCustomers;
use App\Models\Customer;

class CustomerOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage()
    {
        return ListCustomers::class;
    }

    protected function getStats(): array
    {
        $customers = Customer::all();
        $active_customers = $customers->where('aktif', true)->count();
        $inactive_customers = $customers->where('aktif', false)->count();

        return [
            Stat::make('Total Customer', $customers->count())
                ->description('Jumlah total customer terdaftar')
                ->color('primary')
                ->icon('heroicon-o-users'),
            Stat::make('Customer Aktif', $active_customers)
                ->color('success')
                ->description('Jumlah customer yang aktif')
                ->icon('heroicon-o-check-circle'),
            Stat::make('Customer Non Aktif', $inactive_customers)
                ->color('danger')
                ->description('Jumlah customer yang tidak aktif')
                ->icon('heroicon-o-x-circle'),
        ];
    }
}
