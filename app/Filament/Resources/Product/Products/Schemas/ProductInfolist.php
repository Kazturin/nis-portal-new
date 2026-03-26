<?php

namespace App\Filament\Resources\Product\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title_kk'),
                TextEntry::make('title_ru'),
                TextEntry::make('title_en')
                    ->placeholder('-'),
                TextEntry::make('slug'),
                IconEntry::make('active')
                    ->boolean()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('menu_id')
                    ->numeric()
                    ->placeholder('-'),
            ]);
    }
}
