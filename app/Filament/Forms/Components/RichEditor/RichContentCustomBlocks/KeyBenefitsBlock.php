<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

class KeyBenefitsBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'key_benefits';
    }

    public static function getLabel(): string
    {
        return 'Key benefits';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the key benefits block')
            ->schema([
                TextInput::make('text'),
                ColorPicker::make('color'),
                FileUpload::make('icon')
                    ->image()
                    ->disk('public')
                    ->directory('product/advantages')
                    ->label('Картинка')
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.key-benefits.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.key-benefits.index', $config)->render();
    }
}
