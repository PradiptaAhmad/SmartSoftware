<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\ActionsPosition;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Filters\SelectFilter;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'Customer / User';
    protected static ?string $modelLabel = 'Customer / User';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Manajemen User';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('softid')
                    ->label('Software ID')
                    ->readOnly(),
                TextInput::make('user_reg')
                    ->label('No Registrasi')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->validationMessages(messages: [
                        'unique' => 'No Registrasi Tidak Boleh Sama',
                    ]),
                TextInput::make('nama')
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
            ->modifyQueryUsing(
                function (Builder $query) {
                    $query->withSum('resellers as total_saldo_reseller', 'saldo')
                        ->withCount('resellers as total_reseller');
                }
            )
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
                TextColumn::make('user_reg')
                    ->label('No Registrasi')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nama')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('softid')
                    ->label('Software ID')
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
                TextColumn::make('total_reseller')
                    ->label('Total RS')
                    ->counts('resellers')
                    ->sortable(),
                TextColumn::make('total_saldo_reseller')
                    ->label('Total Saldo')
                    ->sum('resellers', 'saldo')
                    ->sortable()
                    ->default(0)
                    ->money('IDR')
            ])
            ->recordAction('view')
            ->filters([
                SelectFilter::make('aktif')
                    ->label('Aktif')
                    ->options([
                        true => 'Aktif',
                        false => 'Non Aktif',
                    ])
            ])
            ->recordUrl(
                fn(User $record): string => ViewUser::getUrl([$record->id]),
            )
            ->actions([], position: ActionsPosition::BeforeColumns)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
            'view-reseller' => Pages\ViewResellerPage::route('/{record}/view-reseller'),
        ];
    }
}
