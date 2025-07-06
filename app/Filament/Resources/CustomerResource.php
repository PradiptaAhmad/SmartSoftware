<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CustomerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerResource\RelationManagers;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'Customer';
    protected static ?string $modelLabel = 'Customer';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Manajemen Customer';

    public static function canCreate(): bool
    {
        return false;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('softid')
                    ->label('Software ID')
                    ->readOnly(),
                TextInput::make('user_reg')
                    ->label('Nama')
                    ->required()
                    ->validationMessages(messages: [
                        'validation.required' => 'Nama Tidak Boleh Kosong',
                    ]),
                TextInput::make('kontak')
                    ->label('Kontak')
                    ->required()
                    ->validationMessages(messages: [
                        'validation.required' => 'Kontak Tidak Boleh Kosong',
                    ]),
                DatePicker::make('expired')
                    ->displayFormat('d F Y')
                    ->hiddenOn('create')
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('aktif')
                    ->label('Aktif')
                    ->boolean()
                    ->icon(fn($state) => match ($state) {
                        true => 'heroicon-o-check-circle',
                        false => 'heroicon-o-x-circle',
                    })
                    ->color(fn($state) => match ($state) {
                        true => 'success',
                        false => 'danger',
                    }),
                TextColumn::make('id')
                    ->label('No Registrasi')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user_reg')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kontak')
                    ->label('Kontak')
                    ->searchable(),
                TextColumn::make('saldo')
                    ->label('Saldo')
                    ->money('IDR', true)
                    ->sortable(),
                TextColumn::make('expired')
                    ->label('Masa Berlalu')
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
            'view-reseller' => Pages\ViewReseller::route('/{record}/view-reseller'),
        ];
    }
}
