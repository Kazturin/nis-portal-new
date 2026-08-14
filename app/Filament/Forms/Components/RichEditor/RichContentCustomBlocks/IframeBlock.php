<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

class IframeBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'iframe';
    }

    public static function getLabel(): string
    {
        return 'Iframe (Вставка кода)';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Настройка Iframe')
            ->schema([
                TextInput::make('url')
                    ->label('URL (Ссылка)')
                    ->required()
                    ->placeholder('https://example.com'),
                TextInput::make('height')
                    ->label('Высота (px)')
                    ->default('500px')
                    ->required(),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.iframe.preview', [
            'url' => $config['url'] ?? '',
            'height' => $config['height'] ?? '500px',
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.iframe.index', [
            'url' => $config['url'] ?? '',
            'height' => $config['height'] ?? '500px',
        ])->render();
    }
}
