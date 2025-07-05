<?php

namespace App\Livewire;

use App\Exports\ResellerExport;
use App\Filament\Resources\UserResource\Pages\ViewResellerPage;
use App\Models\Reseller;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\HeaderActionsPosition;
use Filament\Tables\Concerns\InteractsWithTable;
use Maatwebsite\Excel\Facades\Excel;

class ListResellers extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Model $record;

    public function mount(Model $record)
    {
        $this->record = $record;
    }

    public function table(Table $table)
    {
        return $table
            ->query(\App\Models\Reseller::query())
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('kode_customer', $this->record->id);
            })
            ->recordUrl(fn(Reseller $record) => ViewResellerPage::getUrl(['record' => $record->kode]))
            ->headerActions([
                Action::make('export_excel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary')
                    ->action(function () {
                        return Excel::download(new ResellerExport($this->record->id), 'reseller_' . $this->record->id . '_' . now()->format('Ymd_His') . '.xlsx');
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
            ])
            ->filters([
                // Define your filters here
            ])
            ->actions([
                // Define your actions here
            ]);
    }
    public function render()
    {
        return view('livewire.list-resellers');
    }
}
