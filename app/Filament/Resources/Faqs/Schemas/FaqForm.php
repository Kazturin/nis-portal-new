<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->schema([
                        Select::make('language')
                            ->label('Язык')
                            ->required()
                            ->options([
                                'kk' => 'Казақша',
                                'ru' => 'Русский',
                                'en' => 'English',
                            ]),
                        TextInput::make('question')
                            ->label('Вопрос')
                            ->required()
                            ->maxLength(510),
                        RichEditor::make('answer')
                            ->label('Ответ')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('sort')
                            ->label('Сортировка')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])->columnSpanFull()
            ]);
    }
}
