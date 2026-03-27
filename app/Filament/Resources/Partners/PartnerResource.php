<?php

namespace App\Filament\Resources\Partners;

use App\Filament\Resources\Partners\Pages\ManagePartners;
use App\Models\Partner;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?int $navigationSort = 7;

    protected static ?string $navigationLabel = 'Партнеры';

    protected static ?string $modelLabel = 'Партнер';

    protected static ?string $pluralModelLabel = 'Партнеры';

    protected static ?string $recordTitleAttribute = 'link';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('link')
                    ->label('Ссылка')
                    ->maxLength(255)
                    ->columnSpanFull(),
                FileUpload::make('logo')
                    ->label('Логотип')
                    ->required()
                    ->disk('public')
                    ->directory('partners_logo'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('link')
            ->columns([
                ImageColumn::make('logo')
                    ->label('Логотип')
                    ->disk('public')
                    ->searchable(),
                TextColumn::make('link')
                    ->label('Ссылка')
                    ->url(function (Partner $partner) {
                        return $partner->link ?? '#';
                    }),
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
            'index' => ManagePartners::route('/'),
        ];
    }
}
