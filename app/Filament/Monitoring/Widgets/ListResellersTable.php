<?php

namespace App\Filament\Monitoring\Widgets;

use Filament\Tables;
use App\Models\Reseller;
use Filament\Tables\Table;
use App\Exports\ResellerExport;
use App\Filament\Monitoring\Pages\ViewResellerMonitoring;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Actions\HeaderActionsPosition;
use App\Filament\Resources\UserResource\Pages\ViewResellerPage;

class ListResellersTable extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';


    public function table(Table $table): Table
    {
        $user = auth()->user();
        return $table
            ->heading('Daftar Reseller')
            ->query(
                Reseller::query()
            )
            ->modifyQueryUsing(function ($query) use ($user) {
                return $query->where('kode_customer', $user->id);
            })
            ->recordUrl(fn (Reseller $record) => ViewResellerMonitoring::getUrl(['record' => $record->kode]))
            ->headerActions([
                Action::make('export_excel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary')
                    ->action(function () {
                        return Excel::download(new ResellerExport(auth()->user()->id), 'reseller_' . $this->record->id . '_' . now()->format('Ymd_His') . '.xlsx');
                    }),
            ], HeaderActionsPosition::Adaptive)
            ->columns([
                IconColumn::make('aktif')
                    ->icon(fn(bool $state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn(bool $state) => $state ? 'success' : 'danger')
                    ->label('Aktif'),
                TextColumn::make('kode')
                    ->label('Kode Reseller')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nama')
                    ->label('Nama Reseller')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('saldo')
                    ->label('Saldo')
                    ->money('IDR', true)
                    ->sortable(),
                TextColumn::make('komisi')
                    ->label('Komisi')
                    ->money('IDR', true)
                    ->sortable(),
                TextColumn::make('pin')
                    ->label('PIN'),
                TextColumn::make('kode_upline')
                    ->label('Kode Upline')
                    ->searchable(),
                TextColumn::make('kode_level')
                    ->label('Kode Level')
                    ->sortable(),
                TextColumn::make('markup')
                    ->label('Markup')
                    ->money('IDR', true)
                    ->sortable(),
                TextColumn::make('markup_ril')
                    ->label('Markup Ril')
                    ->money('IDR', true)
                    ->sortable(),
                TextColumn::make('keterangan')
                    ->label('Keterangan'),
                TextColumn::make('kode_area')
                    ->label('Kode Area')
                    ->searchable(),
                TextColumn::make('tgl_aktivitas')
                    ->label('Tanggal Aktivitas')
                    ->date('d F Y')
                    ->sortable(),
                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(50),
                TextColumn::make('pengirim')
                    ->label('Pengirim')
                    ->searchable(),
            ]);
    }
}
