<?php

namespace App\Filament\Resources\TextWidgets;

use App\Filament\Resources\TextWidgets\Pages\CreateTextWidget;
use App\Filament\Resources\TextWidgets\Pages\EditTextWidget;
use App\Filament\Resources\TextWidgets\Pages\ListTextWidgets;
use App\Filament\Resources\TextWidgets\Pages\ViewTextWidget;
use App\Filament\Resources\TextWidgets\Schemas\TextWidgetForm;
use App\Filament\Resources\TextWidgets\Schemas\TextWidgetInfolist;
use App\Filament\Resources\TextWidgets\Tables\TextWidgetsTable;
use App\Models\TextWidget;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TextWidgetResource extends Resource
{
    protected static ?string $model = TextWidget::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'key';

    public static function form(Schema $schema): Schema
    {
        return TextWidgetForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TextWidgetInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TextWidgetsTable::configure($table);
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
            'index' => ListTextWidgets::route('/'),
            'create' => CreateTextWidget::route('/create'),
            'view' => ViewTextWidget::route('/{record}'),
            'edit' => EditTextWidget::route('/{record}/edit'),
        ];
    }
}
