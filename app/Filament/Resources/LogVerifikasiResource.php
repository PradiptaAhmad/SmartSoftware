<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogVerifikasiResource\Pages;
use App\Filament\Resources\LogVerifikasiResource\RelationManagers;
use App\Models\LogVerifikasi;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LogVerifikasiResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 3;
    protected static ?string $recordTitleAttribute = 'Log Verifikasi';
    protected static ?string $modelLabel = 'Log Verifikasi';
    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationGroup = 'Laporan dan Log';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_log')
                    ->label('Kode'),
                TextColumn::make('tgl_entri')
                    ->label('Tanggal Entri'),
                TextColumn::make('status_log')
                    ->label('Status'),
                TextColumn::make('tgl_status')
                    ->label('Tanggal Status'),
                TextColumn::make('ip')
                    ->label('Alamat IP'),
                TextColumn::make('pesan')
                    ->label('Pesan'),
            ])
            ->filters([
                //
            ])
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
            'index' => Pages\ListLogVerifikasis::route('/'),
            'create' => Pages\CreateLogVerifikasi::route('/create'),
            'edit' => Pages\EditLogVerifikasi::route('/{record}/edit'),
        ];
    }
}
