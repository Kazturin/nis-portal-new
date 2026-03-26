<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title_kk'),
                TextEntry::make('title_ru'),
                TextEntry::make('title_en'),
                // TextEntry::make('content_kk')
                //     ->columnSpanFull(),
                // TextEntry::make('content_ru')
                //     ->columnSpanFull(),
                // TextEntry::make('content_en')
                //     ->columnSpanFull(),
                TextEntry::make('slug'),
                TextEntry::make('menu_id')
                    ->numeric(),
                TextEntry::make('parent_id')
                    ->numeric()
                    ->placeholder('-'),
                IconEntry::make('active')
                    ->boolean(),
                IconEntry::make('is_protected')
                    ->boolean(),
                TextEntry::make('lists_view_type')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_by')
                    ->numeric(),
                TextEntry::make('updated_by')
                    ->numeric(),
            ]);
    }
}
