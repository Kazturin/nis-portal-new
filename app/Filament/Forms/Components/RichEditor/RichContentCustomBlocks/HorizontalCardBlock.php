<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class HorizontalCardBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'horizontal_card';
    }

    public static function getLabel(): string
    {
        return 'Horizontal card';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the horizontal card block')
            ->modalWidth('5xl')
            ->schema([
                TextInput::make('title'),
                RichEditor::make('description')
                    ->resizableImages()
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'link', 'textColor'],
                        ['h2', 'h3', 'h4', 'alignStart', 'alignCenter', 'alignEnd'],
                        ['bulletList', 'orderedList'],
                        ['attachFiles', 'grid', 'customBlocks'],
                        ['undo', 'redo'],
                    ])
                    ->customTextColors()
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('pages/content/attachments'),
                TextInput::make('button_text'),
                TextInput::make('button_url'),
                Radio::make('image_style')
                    ->options([
                        'contain' => 'Contain (Logo)',
                        'cover' => 'Cover (Banner)',
                    ])
                    ->default('contain')
                    ->inline(),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('pages/content/attachments'),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.horizontal-card.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.horizontal-card.index', $config)->render();
    }
}
