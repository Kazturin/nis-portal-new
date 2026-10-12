<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Заголовки')
                    ->schema([
                        TextEntry::make('title_kk')
                            ->label('На казахском')
                            ->placeholder('Не указан'),
                        TextEntry::make('title_ru')
                            ->label('На русском')
                            ->placeholder('Не указан'),
                        TextEntry::make('title_en')
                            ->label('На английском')
                            ->placeholder('Не указан'),
                    ])
                    ->columns(['md' => 3])
                    ->columnSpanFull(),
                Section::make('Параметры страницы')
                    ->schema([
                        TextEntry::make('slug')
                            ->label('Адрес страницы')
                            ->copyable(),
                        TextEntry::make('menu.title_ru')
                            ->label('Меню')
                            ->placeholder('Не указано'),
                        TextEntry::make('parent.title_ru')
                            ->label('Родительская страница')
                            ->placeholder('Нет родительской страницы'),
                        IconEntry::make('active')
                            ->label('Активна')
                            ->boolean(),
                        IconEntry::make('is_protected')
                            ->label('Защищённая страница')
                            ->boolean(),
                        TextEntry::make('lists_view_type')
                            ->label('Шаблон отображения списков')
                            ->badge()
                            ->placeholder('Не указан'),
                    ])
                    ->columns(['md' => 3])
                    ->columnSpanFull(),
                Section::make('История изменений')
                    ->schema([
                        TextEntry::make('creator.name')
                            ->label('Создал')
                            ->placeholder('Не указан'),
                        TextEntry::make('created_at')
                            ->label('Дата создания')
                            ->dateTime('d.m.Y H:i')
                            ->placeholder('Не указана'),
                        TextEntry::make('edited.name')
                            ->label('Обновил')
                            ->placeholder('Не указан'),
                        TextEntry::make('updated_at')
                            ->label('Дата обновления')
                            ->dateTime('d.m.Y H:i')
                            ->placeholder('Не указана'),
                    ])
                    ->columns(['md' => 2])
                    ->columnSpanFull(),
            ]);
    }
}
