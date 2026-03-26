<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

class VerticalCardBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'vertical_card';
    }

    public static function getLabel(): string
    {
        return 'Vertical card';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the vertical card block')
            ->schema([
                TextInput::make('title'),
                RichEditor::make('description')
                    ->resizableImages()
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'link'],
                        ['h3', 'h4', 'alignStart', 'alignCenter', 'alignEnd'],
                        ['bulletList', 'orderedList'],
                        ['undo', 'redo'],
                    ]),
                TextInput::make('button_text'),
                TextInput::make('button_url'),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('pages/content/attachments'),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.vertical-card.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.vertical-card.index', $config)->render();
    }
}
