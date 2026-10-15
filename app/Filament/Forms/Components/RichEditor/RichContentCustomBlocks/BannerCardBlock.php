<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Filament\Forms\Components\TextInput;

class BannerCardBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'banner_card';
    }

    public static function getLabel(): string
    {
        return 'Карточка с фоновым изображением';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Настройте фон, иконку и тексты карточки')
            ->modalWidth('4xl')
            ->schema([
                FileUpload::make('background_image')
                    ->label('Фоновое изображение')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([null, '3:1'])
                    ->helperText('Загрузите готовый фон без текста. Белые поля можно обрезать в редакторе изображения.')
                    ->disk('public')
                    ->visibility('public')
                    ->directory('pages/content/banners')
                    ->required(),
                FileUpload::make('icon')
                    ->label('Иконка / логотип слева')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->directory('pages/content/banners/icons'),
                TextInput::make('title')
                    ->label('Заголовок')
                    ->maxLength(255)
                    ->required(),
                ColorPicker::make('title_color')
                    ->label('Цвет заголовка')
                    ->hexColor()
                    ->default('#245522'),
                RichEditor::make('description')
                    ->label('Описание')
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'link'],
                        ['bulletList', 'orderedList'],
                        ['undo', 'redo'],
                    ])
                    ->json(),
                ColorPicker::make('text_color')
                    ->label('Цвет описания')
                    ->hexColor()
                    ->default('#31572E'),
                TextInput::make('url')
                    ->label('Ссылка')
                    ->maxLength(255),    
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return static::toHtml($config, []);
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.banner-card.index', [
            ...$config,
            'description' => filled($config['description'] ?? null)
                ? RichContentRenderer::make($config['description'])->toHtml()
                : '',
        ])->render();
    }
}
