<?php

namespace App\Filament\Resources;

use Dom\Text;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Reseller;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ResellerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ResellerResource\RelationManagers;

class ResellerResource extends Resource
{
    protected static ?string $model = Reseller::class;

    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'Reseller';
    protected static ?string $modelLabel = 'Reseller';
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Manajemen Reseller & Customer';

    public static function canViewAny(): bool
    {
        return false;
    }
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id_mitra')
                    ->required(),
                TextInput::make('nama')
                    ->required(),
                TextInput::make('grup')
                    ->required(),
                TextInput::make('kode_upline')
                    ->required(),

                TextInput::make('saldo')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->stripCharacters('.')
                    ->mask(RawJs::make(<<<'JS'
$money($input, ',', '.', 2)
JS)),
                TextInput::make('limit_saldo')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->stripCharacters('.')
                    ->mask(RawJs::make(<<<'JS'
$money($input, ',', '.', 2)
JS))

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode')
                    ->label('Kode Reseller')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nama')
                    ->label('Nama Reseller')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_rs')
                    ->label('Total RS')
                    ->sortable(),
                TextColumn::make('saldo')
                    ->label('Saldo Reseller')
                    ->sortable()
                    ->money('idr', true),
                TextColumn::make('tagihan_sewa')
                    ->label('Tagihan Sewa')
                    ->state(function (Model $record) {
                        return 25 * $record->total_rs;
                    })
                    ->money('idr', true),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('registered_from')
                            ->label('Didaftarkan Sejak')

                            ->displayFormat('d F Y')
                            ->native(false),
                        DatePicker::make('registered_until')
                            ->label('Didaftarkan Sampai Dengan')

                            ->displayFormat('d F Y')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['registered_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tgl_daftar', '>=', $date),
                            )
                            ->when(
                                $data['registered_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tgl_daftar', '<=', $date),
                            );
                    })->indicateUsing(function (array $data) {
                        $indicators = [];

                        if ($data['registered_from'] ?? null) {
                            $indicators[] = Indicator::make('Didaftarkan Sejak ' . Carbon::parse($data['registered_from'])->translatedFormat('d F Y'))
                                ->removeField('registered_from');
                        }

                        if ($data['registered_until'] ?? null) {
                            $indicators[] = Indicator::make('Didaftarkan Hingga ' . Carbon::parse($data['registered_until'])->translatedFormat('d F Y'))
                                ->removeField('registered_until');
                        }
                        return $indicators;
                    })
            ])
            ->recordAction('view')
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResellers::route('/'),
            'create' => Pages\CreateReseller::route('/create'),
            'view' => Pages\ViewReseller::route('/{record}'),
            'edit' => Pages\EditReseller::route('/{record}/edit'),
        ];
    }
}
