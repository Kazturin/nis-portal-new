<?php

namespace App\Filament\Resources\Product\Products;

use App\Filament\Resources\Product\Products\Pages\CreateProduct;
use App\Filament\Resources\Product\Products\Pages\EditProduct;
use App\Filament\Resources\Product\Products\Pages\ListProducts;
use App\Filament\Resources\Product\Products\Pages\ViewProduct;
use App\Filament\Resources\Product\Products\Schemas\ProductForm;
use App\Filament\Resources\Product\Products\Schemas\ProductInfolist;
use App\Filament\Resources\Product\Products\Tables\ProductsTable;
use App\Models\Product\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title_kk';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationLabel = 'Продукты';

    protected static ?string $modelLabel = 'Продукт';

    protected static ?string $pluralModelLabel = 'Продукты';

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'view' => ViewProduct::route('/{record}'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
