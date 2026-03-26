<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;

class GallerySliderBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'gallery_slider';
    }

    public static function getLabel(): string
    {
        return 'Галерея';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Настройте блок галереи')
            ->schema([
                TextInput::make('id')
                    ->default('slider-' . Str::random(8)),
                TextInput::make('title')
                    ->label('Заголовок'),
                TextInput::make('slidesPerView')
                    ->label('Количество слайдов')
                    ->numeric()
                    ->default(2.5),
                TextInput::make('height')
                    ->label('Высота (px)')
                    ->numeric()
                    ->default(400)
                    ->suffix('px'),
                Repeater::make('images')
                    ->label('Галерея')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Изображение')
                            ->image()
                            ->disk('public')
                            ->directory('gallery'),
                    ])
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.gallery-slider.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.gallery-slider.index', $config)->render();
    }
}
