<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class NewsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title_kk'),
                TextEntry::make('title_ru'),
                TextEntry::make('title_en')
                    ->placeholder('-'),
                TextEntry::make('content_kk')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('content_ru')
                    ->columnSpanFull(),
                TextEntry::make('content_en')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('slug')
                    ->placeholder('-'),
                TextEntry::make('thumbnail')
                    ->placeholder('-'),
                TextEntry::make('meta_title')
                    ->placeholder('-'),
                TextEntry::make('meta_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('published_at')
                    ->dateTime()
                    ->placeholder('-'),
                IconEntry::make('active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('category_id')
                    ->numeric(),
            ]);
    }
}
