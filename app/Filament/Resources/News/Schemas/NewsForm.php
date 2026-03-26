<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title_kk')
                    ->required(),
                TextInput::make('title_ru')
                    ->required(),
                TextInput::make('title_en'),
                Textarea::make('content_kk')
                    ->columnSpanFull(),
                Textarea::make('content_ru')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('content_en')
                    ->columnSpanFull(),
                TextInput::make('slug'),
                TextInput::make('thumbnail'),
                TextInput::make('meta_title'),
                Textarea::make('meta_description')
                    ->columnSpanFull(),
                DateTimePicker::make('published_at'),
                Toggle::make('active')
                    ->required(),
                TextInput::make('gallery'),
                TextInput::make('category_id')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
