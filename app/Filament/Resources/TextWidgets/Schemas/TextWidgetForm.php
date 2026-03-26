<?php

namespace App\Filament\Resources\TextWidgets\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TextWidgetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required(),
                TextInput::make('title_kk')
                    ->required(),
                TextInput::make('title_ru')
                    ->required(),
                TextInput::make('title_en')
                    ->required(),
                Textarea::make('content_kk')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('content_ru')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('content_en')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('active'),
            ]);
    }
}
