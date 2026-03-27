<?php

namespace App\Filament\Resources\TextWidgets\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class TextWidgetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('kz')
                            ->schema([
                                TextInput::make('title_kk')
                                    ->label('Название(KZ)')
                                    ->required()
                                    ->maxLength(255),
                                RichEditor::make('content_kk')
                                    ->label('Контент(KZ)')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('ru')
                            ->schema([
                                TextInput::make('title_ru')
                                    ->label('Название(RU)')
                                    ->required()
                                    ->maxLength(255),
                                RichEditor::make('content_ru')
                                    ->label('Контент(RU)')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('en')
                            ->schema([
                                TextInput::make('title_en')
                                    ->label('Название(EN)')
                                    ->required()
                                    ->maxLength(255),
                                RichEditor::make('content_en')
                                    ->label('Контент(EN)')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpanFull(),
                TextInput::make('key')
                    ->required()
                    ->maxLength(255),
                Toggle::make('active')
                    ->label('Активный')
                    ->default(1),
            ]);
    }
}
