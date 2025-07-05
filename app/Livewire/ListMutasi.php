<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Tables\Table;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListMutasi extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Model $record;

    public function mount(Model $record)
    {
        $this->record = $record;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\Mutasi::query())
            ->modifyQueryUsing(function ($query) {
                $query->where('kode_customer', $this->record->id);
            })
            ->searchable(false)
            ->columns([
                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->sortable(),
                TextColumn::make('saldo')
                    ->label('Saldo')
                    ->money('IDR', true)
                    ->sortable(),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->sortable(),
                TextColumn::make('tipe')
                    ->label('Tipe'),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->sortable()
                    ->date('d F Y H:i:s'),
            ]);
    }
    public function render()
    {
        return view('livewire.list-mutasi');
    }
}
