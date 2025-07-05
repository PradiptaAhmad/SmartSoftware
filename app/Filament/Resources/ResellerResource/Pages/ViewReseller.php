<?php

namespace App\Filament\Resources\ResellerResource\Pages;

use App\Filament\Resources\ResellerResource;
use Filament\Actions;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewReseller extends ViewRecord
{
    protected static string $resource = ResellerResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Reseller')
                    ->schema([
                        TextEntry::make('kode')
                            ->label('Kode Reseller')
                            ->color('primary'),
                        TextEntry::make('nama')
                            ->label('Nama Reseller')
                            ->color('primary'),
                        TextEntry::make('id_mitra')
                            ->label('ID Mitra')
                            ->color('primary'),
                        TextEntry::make('saldo')
                            ->label('Saldo Reseller')
                            ->color('primary')
                            ->money('idr', true),
                        TextEntry::make('limit_saldo')
                            ->label('Limit Saldo')
                            ->color('warning')
                            ->money('idr', true),
                        TextEntry::make('grup')
                            ->label('Grup Reseller')
                            ->color('primary'),
                    ])->columns(2),
                Section::make()
                    ->label('')
                    ->schema([
                        TextEntry::make('kode_upline')
                            ->label('Kode Upline')
                            ->color('primary'),
                        TextEntry::make('markup')
                            ->label('Markup')
                            ->color('primary')
                            ->money('idr', true),
                        TextEntry::make('poin')
                            ->label('Poin')
                            ->color('primary'),
                        TextEntry::make('pin')
                            ->label('PIN Reseller')
                            ->color('primary'),
                        TextEntry::make('nama_pemilik')

                            ->label('Nama Pemilik')
                            ->color('primary'),
                        TextEntry::make('alamat')
                            ->label('Alamat')
                            ->color('primary'),
                        IconEntry::make('suspend')
                            ->icon(fn($state) => match ($state) {
                                true => 'heroicon-o-check-circle',
                                false => 'heroicon-o-x-circle',
                            })
                            ->color(fn($state) => match ($state) {
                                true => 'success',
                                false => 'danger',
                            }),
                        TextEntry::make('keterangan')
                            ->label('Keterangan')
                            ->color('primary'),

                    ])->columns(2),
                Section::make()
                    ->label('')
                    ->schema([
                        TextEntry::make('oid')
                            ->label('OID')
                            ->color('primary'),
                        TextEntry::make('alamat_ip')
                            ->label('Alamat IP')
                            ->color('primary'),
                        TextEntry::make('pass_ip')
                            ->label('Password IP')
                            ->color('primary'),
                        TextEntry::make('url_report')
                            ->label('URL Report')
                            ->color('primary'),
                        TextEntry::make('kode_area')
                            ->label('Kode Area')
                            ->color('primary'),
                        TextEntry::make('pengirim')
                            ->label('Pengirim')
                            ->color('primary'),
                        TextEntry::make('tgl_daftar')
                            ->label('Tanggal Daftar')
                            ->color('primary')
                            ->since(),
                        TextEntry::make('tgl_aktivitas')
                            ->label('Tanggal Aktivitas')
                            ->color('primary')
                            ->since(),
                    ])->columns(2),
            ]);
    }
}
