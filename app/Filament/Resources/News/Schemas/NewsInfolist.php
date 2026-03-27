<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->schema([
                        TextEntry::make('title_kk')
                            ->label('Заголовок(kz)'),
                        TextEntry::make('title_ru')
                            ->label('Заголовок(ru)'),
                        TextEntry::make('title_en')
                            ->label('Заголовок(en)')
                            ->placeholder('-'),
                        TextEntry::make('content_kk')
                            ->label('Контент(kz)')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('content_ru')
                            ->label('Контент(ru)')
                            ->columnSpanFull(),
                        TextEntry::make('content_en')
                            ->label('Контент(en)')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('slug')
                            ->label('Slug')
                            ->placeholder('-'),
                        TextEntry::make('thumbnail')
                            ->label('Превью')
                            ->placeholder('-'),
                        TextEntry::make('meta_title')
                            ->label('Мета заголовок')
                            ->placeholder('-'),
                        TextEntry::make('meta_description')
                            ->label('Мета описание')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('published_at')
                            ->label('Дата публикации')
                            ->dateTime()
                            ->placeholder('-'),
                        IconEntry::make('active')
                            ->label('Активен')
                            ->boolean(),
                        TextEntry::make('created_at')
                            ->label('Дата создания')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label('Дата обновления')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('category_id')
                            ->numeric(),
                    ])->columnSpanFull()
            ]);
    }
}
