<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

class TextSliderBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'text_slider';
    }

    public static function getLabel(): string
    {
        return 'Text slider';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the text slider block')
            ->schema([
                Repeater::make('slides')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title'),
                        RichEditor::make('text')
                            ->label('Text')
                            ->required(),
                    ])
                    ->required(),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.text-slider.preview', [
            'slides' => $config['slides'],
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.text-slider.index', [
            'slides' => $config['slides'],
        ])->render();
    }
}
