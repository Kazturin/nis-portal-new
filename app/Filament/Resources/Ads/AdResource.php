<?php

namespace App\Filament\Resources\Ads;

use App\Filament\Resources\Ads\Pages\ManageAds;
use App\Models\Ad;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'banner_ru';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('banner_ru')
                    ->required(),
                TextInput::make('banner_kk')
                    ->required(),
                TextInput::make('banner_en'),
                TextInput::make('link'),
                TextInput::make('link_kk'),
                TextInput::make('link_ru'),
                TextInput::make('link_en'),
                TextInput::make('position')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('banner_ru')
            ->columns([
                TextColumn::make('banner_ru')
                    ->searchable(),
                TextColumn::make('banner_kk')
                    ->searchable(),
                TextColumn::make('banner_en')
                    ->searchable(),
                TextColumn::make('link')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('link_kk')
                    ->searchable(),
                TextColumn::make('link_ru')
                    ->searchable(),
                TextColumn::make('link_en')
                    ->searchable(),
                TextColumn::make('position')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAds::route('/'),
        ];
    }
}
