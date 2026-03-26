<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

class ContactBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'contact';
    }

    public static function getLabel(): string
    {
        return 'Contact';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the contact block')
            ->schema([
                TextInput::make('title')
                    ->required(),
                TextInput::make('map_url'),
                Repeater::make('items')
                    ->schema([
                        FileUpload::make('icon')
                            ->image()
                            ->directory('contact')
                            ->disk('public')
                            ->label('Иконка'),
                        RichEditor::make('text')
                            ->required(),
                    ])
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.contact.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.contact.index', $config)->render();
    }
}
