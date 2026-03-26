<?php

namespace App\Filament\Resources\TextWidgets\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TextWidgetInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('key'),
                TextEntry::make('title_kk'),
                TextEntry::make('title_ru'),
                TextEntry::make('title_en'),
                TextEntry::make('content_kk')
                    ->columnSpanFull(),
                TextEntry::make('content_ru')
                    ->columnSpanFull(),
                TextEntry::make('content_en')
                    ->columnSpanFull(),
                IconEntry::make('active')
                    ->boolean()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
