<?php
namespace App\Filament\Resources\ResellerResource\Widgets;

use App\Filament\Resources\ResellerResource\Pages\ListResellers;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\Reseller;

class ResellerOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage()
    {
        return ListResellers::class;
    }

    protected function getStats(): array
    {
        $reseller = Reseller::all();
        $total_reseller = $reseller->count();
        $total_saldo_reseller = 'Rp ' . number_format($reseller->sum('saldo'), 0, ',', '.');

        return [
            Stat::make('Total reseller', $total_reseller)
                ->description('Jumlah total reseller terdaftar')
                ->color('primary')
                ->icon('heroicon-o-users'),
            Stat::make('Total saldo', $total_saldo_reseller)
                ->description('Jumlah total saldo reseller')
                ->color('success')
                ->icon('heroicon-o-banknotes'),
        ];
    }
}
