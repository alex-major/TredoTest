<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserDeviceResource\Pages;
use App\Filament\Resources\UserDeviceResource\RelationManagers;
use App\Models\UserDevice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserDeviceResource extends Resource
{
    protected static ?string $model = UserDevice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
					->relationship('user', 'name')
					->searchable()
					->preload()
					->required(),
				Forms\Components\TextInput::make('fcm_token')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
				Tables\Columns\TextColumn::make('user.name'),
				Tables\Columns\TextColumn::make('fcm_token'),
				Tables\Columns\TextColumn::make('created_at'),
				Tables\Columns\TextColumn::make('updated_at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
				Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
				//
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
            'index' => Pages\ListUserDevices::route('/'),
            'create' => Pages\CreateUserDevice::route('/create'),
            'edit' => Pages\EditUserDevice::route('/{record}/edit'),
        ];
    }
}
