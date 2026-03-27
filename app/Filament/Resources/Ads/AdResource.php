<?php

namespace App\Filament\Resources\Ads;

use App\Filament\Resources\Ads\Pages\ManageAds;
use App\Models\Ad;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?int $navigationSort = 8;

    protected static ?string $navigationLabel = 'Рекламный баннеры';

    protected static ?string $modelLabel = 'Рекламный баннер';

    protected static ?string $pluralModelLabel = 'Рекламный баннеры';

    protected static ?string $recordTitleAttribute = 'banner_ru';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('')
                    ->tabs([
                        Tabs\Tab::make('kz')
                            ->schema([
                                FileUpload::make('banner_kk')
                                    ->required()
                                    ->image()
                                    ->disk('public')
                                    ->directory('banner')
                                    ->label('Баннер(kz)'),

                                TextInput::make('link_kk')
                                    ->maxLength(255),
                            ]),
                        Tabs\Tab::make('ru')
                            ->schema([
                                FileUpload::make('banner_ru')
                                    ->required()
                                    ->image()
                                    ->disk('public')
                                    ->directory('banner')
                                    ->label('Баннер(ru)'),
                                TextInput::make('link_ru')
                                    ->maxLength(255),
                            ]),
                        Tabs\Tab::make('en')
                            ->schema([
                                FileUpload::make('banner_en')
                                    ->image()
                                    ->disk('public')
                                    ->directory('banner')
                                    ->label('Баннер(en)'),
                                TextInput::make('link_en')
                                    ->maxLength(255),
                            ])
                    ])->columnSpanFull(),

                TextInput::make('position')
                    ->label('Позиция')
                    ->numeric()
                    ->default(0),
                Toggle::make('active')
                    ->label('Активен')
                    ->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('banner_ru')
            ->columns([
                ImageColumn::make('banner_kk')
                    ->label('Баннер')
                    ->disk('public'),
                TextColumn::make('link_kk')
                    ->label('Ссылка')
                    ->searchable(),
                TextColumn::make('position')
                    ->label('Позиция')
                    ->searchable(),
                IconColumn::make('active')
                    ->label('Активен')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
