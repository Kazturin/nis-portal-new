<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

class BorderedTextBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'bordered_text';
    }

    public static function getLabel(): string
    {
        return 'Bordered text';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the bordered text block')
            ->schema([
                TextInput::make('text'),
                TextInput::make('color'),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('product/advantages')
                    ->label('Картинка')
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.bordered-text.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.bordered-text.index', $config)->render();
    }
}
