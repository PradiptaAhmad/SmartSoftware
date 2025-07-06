<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use Exception;
use App\Models\User;
use Filament\Forms\Set;
use Filament\Support\RawJs;
use Illuminate\Support\Str;
use App\Livewire\ListMutasi;
use Filament\Actions\Action;
use App\Livewire\ListResellers;
use App\Models\Mutasi;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\RichEditor;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Livewire;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\Actions\Action as FormAction;

class ViewCustomer extends ViewRecord
{
    protected static string $resource = \App\Filament\Resources\CustomerResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Action::make('tambah_saldo')
                ->label('Tambah Saldo')
                ->icon('heroicon-o-plus-circle')
                ->color('primary')
                ->form([
                    TextInput::make('tambah_saldo')
                        ->label('Nominal')
                        ->placeholder('Masukkan Nominal Saldo')
                        ->required()
                        ->prefix('Rp')
                        ->live()
                        ->mask(RawJs::make(<<<'JS'
$money($input, ',', '.', 2)
JS)),
                    Textarea::make('keterangan_deposit')
                        ->label('Keterangan Deposit')
                        ->placeholder('Masukkan Keterangan Deposit')
                        ->required()
                ])
                ->action(function ($record, array $data) {
                    try {
                        DB::beginTransaction();

                        Mutasi::create([
                            'jumlah' => (int) str_replace('.', '', $data['tambah_saldo']),
                            'keterangan' => $data['keterangan_deposit'],
                        ]);



                        DB::commit();
                        Notification::make()
                            ->title('Saldo Berhasil Ditambahkan')
                            ->body('Saldo user ' . $record->nama . ' telah berhasil ditambahkan sebesar Rp' . $data['tambah_saldo'])
                            ->success()
                            ->send();
                    } catch (Exception $e) {
                        Notification::make()
                            ->title('Gagal Menambahkan Saldo')
                            ->danger()
                            ->send();
                        DB::rollBack();
                    }
                }),

            // Action::make('edit_software_id')
            //     ->label('Edit Software ID')
            //     ->icon('heroicon-o-pencil-square')
            //     ->color('warning')
            //     ->fillForm([
            //         'software_id' => $this->record->software_id,
            //     ])
            //     ->form([
            //         TextInput::make('software_id')
            //             ->label('Software ID')
            //             ->required()
            //             ->unique(ignoreRecord: true)
            //             ->suffixAction(
            //                 FormAction::make('generate')
            //                     ->label('Generate Baru')
            //                     ->icon('heroicon-o-arrow-path')
            //                     ->color('secondary')
            //                     ->action(function (Set $set) {
            //                         $newSoftwareId = 'softid-' . \Illuminate\Support\Str::random(16);
            //                         while (User::where('software_id', $newSoftwareId)->exists()) {
            //                             $newSoftwareId = 'softid-' . \Illuminate\Support\Str::random(16);
            //                         }
            //                         $set('software_id', $newSoftwareId);
            //                     })
            //             )
            //             ->validationMessages(messages: [
            //                 'unique' => 'Software ID Tidak Boleh Sama',
            //             ])
            //     ])
            //     ->action(function (User $record, array $data) {
            //         try {
            //             DB::beginTransaction();
            //             $record->software_id = $data['software_id'];
            //             $record->save();

            //             DB::commit();
            //             Notification::make()
            //                 ->title('Software ID Berhasil Diubah')
            //                 ->body('Software ID user ' . $record->nama . ' telah berhasil diubah menjadi ' . $data['software_id'])
            //                 ->success()
            //                 ->send();
            //         } catch (Exception $e) {
            //             Notification::make()
            //                 ->title('Gagal Mengubah Software ID')
            //                 ->danger()
            //                 ->send();
            //             DB::rollBack();
            //         }
            //     }),
            EditAction::make()
                ->label('Edit User')
                ->icon('heroicon-o-pencil-square'),
            // DeleteAction::make()
            //     ->label('Hapus User')
            //     ->icon('heroicon-o-trash')
            //     ->color('danger')
            //     ->requiresConfirmation(),
        ];
    }

    public function infolist(\Filament\Infolists\Infolist $infolist): \Filament\Infolists\Infolist
    {
        return $infolist
            ->schema([
                Tabs::make()
                    ->schema([
                        Tab::make('Informasi Customer')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
                                TextEntry::make('id')
                                    ->label('No Registrasi')
                                    ->color('primary'),
                                TextEntry::make('user_reg')
                                    ->label('Nama')
                                    ->color('primary'),
                                TextEntry::make('kontak')
                                    ->label('Kontak')
                                    ->color('primary'),
                                TextEntry::make('saldo')
                                    ->label('Saldo')
                                    ->color('primary')
                                    ->money('idr', true),
                                TextEntry::make('expired')
                                    ->label('Masa Berlaku')
                                    ->color('primary')
                                    ->date('d F Y'),
                                TextEntry::make('tgl_backup')
                                    ->label('Tanggal Backup')
                                    ->color('primary')
                                    ->date('d F Y'),
                                TextEntry::make('total_reseller')
                                    ->label('Total RS')
                                    ->state(function ($record) {
                                        return $record->resellers()->count();
                                    })
                                    ->color('primary'),
                                TextEntry::make('lvl_akses')
                                    ->label('Level Akses')
                                    ->color('primary'),
                                TextEntry::make('upline')
                                    ->label('Upline')
                                    ->color('primary'),
                                TextEntry::make('total_saldo_reseller')
                                    ->label('Total Saldo')
                                    ->state(function ($record) {
                                        return $record->resellers()->sum('saldo');
                                    })
                                    ->money('idr', true)
                                    ->color('primary'),
                                TextEntry::make('online')
                                    ->label('Status')
                                    ->color(function ($state) {
                                        return $this->record->online ? 'success' : 'danger';
                                    })
                                    ->badge()
                                    ->state(function ($record) {
                                        return $record->online = '1' ? 'Online' : 'Offline';
                                    }),
                                TextEntry::make('aktif')
                                    ->label('Aktif')
                                    ->state(function ($record) {
                                        return $record->aktif ? 'Aktif' : 'Tidak Aktif';
                                    })
                                    ->badge()
                                    ->color(function ($state) {
                                        return $this->record->aktif ? 'success' : 'danger';
                                    })
                            ])->columns(2),
                        Tab::make('Daftar Reseller')
                            ->icon('heroicon-o-list-bullet')
                            ->schema([
                                Section::make('Ringkasan Informasi')
                                    ->description('Ringkasan Informasi Reseller Yang Terdaftar')
                                    ->schema([
                                        TextEntry::make('total_reseller')
                                            ->label('Total Reseller')
                                            ->state(function ($record) {
                                                return $record->resellers()->count();
                                            })
                                            ->color('primary'),
                                        TextEntry::make('total_saldo_reseller')
                                            ->label('Total Saldo Reseller')
                                            ->state(function ($record) {
                                                return $record->resellers()->sum('saldo');
                                            })
                                            ->money('idr', true)
                                            ->color('primary'),
                                        TextEntry::make('total_tagihan_sewa')
                                            ->label('Total Tagihan Sewa')
                                            ->state(function ($record) {
                                                return $record->resellers()->count() * 25;
                                            })
                                            ->money('idr', true)
                                            ->color('primary'),
                                    ])->columns(3),

                                Livewire::make(ListResellers::class)
                                    ->key(Str::random(13))
                            ]),
                        Tab::make('Mutasi')
                            ->icon('heroicon-o-credit-card')
                            ->schema([
                                Section::make('Ringkasan Informasi')
                                    ->description('Ringkasan Informasi Mutasi Saldo')
                                    ->schema([
                                        TextEntry::make('saldo')
                                            ->label('Jumlah Saldo Sekarang')
                                            ->money('idr', true)
                                            ->color('primary'),
                                    ])->columnSpanFull(),
                                Livewire::make(ListMutasi::class)
                                    ->key(Str::random(12))
                            ])
                    ])->columnSpanFull()
            ]);
    }
}
