<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class ImageWithOverlayBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'image_with_overlay';
    }

    public static function getLabel(): string
    {
        return 'Image with overlay';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the image with overlay block')
            ->modalWidth('3xl')
            ->schema([
                TextInput::make('title'),
                RichEditor::make('description')
                    ->label('Описание')
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'link', 'textColor'],
                        ['h2', 'h3', 'h4', 'alignStart', 'alignCenter', 'alignEnd'],
                        ['bulletList', 'orderedList'],
                        ['attachFiles', 'grid', 'customBlocks'],
                        ['undo', 'redo'],
                    ])
                    ->customTextColors()
                    ->required(),
                Select::make('type')
                    ->options([
                        1 => 'Вариант 1',
                        2 => 'Вариант 2'
                    ]),
                TextInput::make('max_width')
                    ->default('100%'),
                FileUpload::make('file')
                    ->disk('public')
                    ->directory('product')
                    ->label('Файл'),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('product')
                    ->label('Картинка')
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.image-with-overlay.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.image-with-overlay.index', $config)->render();
    }
}
