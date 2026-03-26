<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

class YoutubeBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'youtube';
    }

    public static function getLabel(): string
    {
        return 'Youtube видео';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Настройка Youtube видео')
            ->schema([
                TextInput::make('url')
                    ->label('Ссылка на Youtube видео')
                    ->required()
                    ->url()
                    ->placeholder('https://www.youtube.com/watch?v=...'),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        $youtubeId = static::getYoutubeId($config['url'] ?? '');

        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.youtube.preview', [
            'url' => $config['url'] ?? '',
            'youtubeId' => $youtubeId,
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        $youtubeId = static::getYoutubeId($config['url'] ?? '');

        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.youtube.index', [
            'url' => $config['url'] ?? '',
            'youtubeId' => $youtubeId,
        ])->render();
    }

    protected static function getYoutubeId(string $url): ?string
    {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?v=|embed\/|v\/|shorts\/))([^\?&\"'>]+)/", $url, $matches);

        return $matches[1] ?? null;
    }
}
