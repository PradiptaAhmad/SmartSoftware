<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogUploadResource\Pages;
use App\Filament\Resources\LogUploadResource\RelationManagers;
use App\Models\LogUpload;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LogUploadResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 4;
    protected static ?string $recordTitleAttribute = 'Log Upload';
    protected static ?string $modelLabel = 'Log Upload';
    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
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
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListLogUploads::route('/'),
            'create' => Pages\CreateLogUpload::route('/create'),
            'edit' => Pages\EditLogUpload::route('/{record}/edit'),
        ];
    }
}
