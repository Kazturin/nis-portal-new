<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;
use Filament\Support\Markdown;

class OrnamentCardBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'ornament_card';
    }

    public static function getLabel(): string
    {
        return 'Ornament card';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the ornament card block')
            ->schema([
                FileUpload::make('icon')
                    ->disk('public')
                    ->directory('icon')
                    ->image(),
                RichEditor::make('description')
                    ->label('Description')
                    ->required(),
                TextInput::make('color')
                    ->label('Color')
                    ->required(),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.ornament-card.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.ornament-card.index', $config)->render();
    }
}
