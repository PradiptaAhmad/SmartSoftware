<?php

namespace App\Filament\Monitoring\Pages;

use App\Models\Reseller;
use Filament\Pages\Page;
use Filament\Infolists\Infolist;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Components\Actions\Action;
use Illuminate\Http\Request;

class ViewResellerMonitoring extends Page implements HasForms, HasInfolists
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.monitoring.pages.view-reseller-monitoring';

    protected $data;

    public function mount(Request $request)
    {;
        $this->data = Reseller::where('kode', $request->record)->firstOrFail();
    }
    public function resellerInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->data)
            ->schema([
                Section::make()
                    ->schema([
                        TextEntry::make('kode')
                            ->color('primary'),
                        TextEntry::make('nama')
                            ->color('primary'),
                        TextEntry::make('saldo')
                            ->color('primary')
                            ->money('idr', true),
                        TextEntry::make('alamat')
                            ->color('primary'),
                        TextEntry::make('pin')
                            ->color('primary'),
                        IconEntry::make('aktif')
                            ->icon(fn(bool $state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                            ->color(fn(bool $state) => $state ? 'success' : 'danger')
                            ->label('Aktif'),
                        TextEntry::make('kode_upline')
                            ->label('Kode Upline')
                            ->color('primary'),
                        TextEntry::make('kode_level')
                            ->label('Kode Level')
                            ->color('primary'),
                        TextEntry::make('keterangan')
                            ->label('Keterangan')
                            ->color('primary'),
                        TextEntry::make('tgl_daftar')
                            ->label('Tanggal Daftar')
                            ->color('primary')
                            ->date('d F Y '),
                        TextEntry::make('tgl_aktivitas')
                            ->label('Tanggal Aktivitas')
                            ->color('primary')
                            ->date('d F Y'),
                        TextEntry::make('saldo_minimal')
                            ->label('Saldo Minimal')
                            ->color('primary')
                            ->money('idr', true),
                        TextEntry::make('pengingat_saldo')
                            ->label('Pengingat Saldo')
                            ->color('primary'),
                        TextEntry::make('f_pengingat_saldo')
                            ->label('Frekuensi Pengingat Saldo')
                            ->color('primary'),
                        TextEntry::make('nama_pemilik')
                            ->label('Nama Pemilik')
                            ->color('primary'),
                        TextEntry::make('kode_area')
                            ->label('Kode Area')
                            ->color('primary'),
                        TextEntry::make('tgl_pengingat_saldo')
                            ->label('Tanggal Pengingat Saldo')
                            ->color('primary')
                            ->date('d F Y'),
                        TextEntry::make('markup')
                            ->label('Markup')
                            ->color('primary')
                            ->money('idr', true),
                        TextEntry::make('markup_ril')
                            ->label('Markup Ril')
                            ->color('primary')
                            ->money('idr', true),
                        TextEntry::make('komisi')
                            ->label('Komisi')
                            ->color('primary'),
                        TextEntry::make('pengirim')
                            ->label('Pengirim')
                            ->color('primary'),
                        TextEntry::make('kode_mutasi')
                            ->label('Kode Mutasi')
                            ->color('primary'),
                    ]),
                Actions::make([
                    Action::make('Kembali')
                        ->icon('heroicon-o-arrow-left')
                        ->color('secondary')
                        ->url(url: url()->previous()),
                ])
            ]);
    }
}
