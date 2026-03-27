<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

class FixedButtonBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'fixed_button';
    }

    public static function getLabel(): string
    {
        return 'Fixed button';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the fixed button block')
            ->schema([
                TextInput::make('title')
                    ->label('Название')
                    ->required(),
                TextInput::make('link')
                    ->label('Ссылка'),
                FileUpload::make('icon')
                    ->label('Иконка')
                    ->image()
                    ->disk('public')
                    ->directory('icon')
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.fixed-button.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.fixed-button.index', $config)->render();
    }
}
