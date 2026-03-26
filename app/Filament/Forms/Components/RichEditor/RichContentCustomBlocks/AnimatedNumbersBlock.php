<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;

class AnimatedNumbersBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'animated_numbers';
    }

    public static function getLabel(): string
    {
        return 'Animated numbers';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the animated numbers block')
            ->schema([
                Repeater::make('cards')
                    ->schema([
                        FileUpload::make('bg_image')
                            ->label('Изображение')
                            ->directory('pages/content')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']),
                        Fieldset::make('Заголовок')
                            ->schema([
                                TextInput::make('number')
                                    ->numeric(),
                                TextInput::make('title')
                                    ->required(),
                            ]),
                        Textarea::make('text')
                            ->required(),
                    ])
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.animated-numbers.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.animated-numbers.index', $config)->render();
    }
}
