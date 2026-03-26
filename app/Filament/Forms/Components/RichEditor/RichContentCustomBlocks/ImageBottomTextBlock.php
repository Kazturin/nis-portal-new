<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;

class ImageBottomTextBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'image_bottom_text';
    }

    public static function getLabel(): string
    {
        return 'Image bottom text';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the image bottom text block')
            ->schema([
                RichEditor::make('text')
                    ->required(),
                FileUpload::make('icon')
                    ->image()
                    ->disk('public')
                    ->directory('product/advantages')
                    ->label('Иконка'),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('product/advantages')
                    ->label('Картинка')
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.image-bottom-text.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.image-bottom-text.index', $config)->render();
    }
}
