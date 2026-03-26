<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Illuminate\Support\Str;

class FullSliderBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'full_slider';
    }

    public static function getLabel(): string
    {
        return 'Full slider';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the full slider block')
            ->modalWidth('4xl')
            ->schema([
                TextInput::make('id')
                    ->default('slider-' . Str::random(8)),
                TextInput::make('title')
                    ->required(),
                RichEditor::make('description')
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'link', 'textColor'],
                        ['h4', 'h5', 'h6', 'alignStart', 'alignCenter', 'alignEnd', 'bulletList', 'orderedList', 'attachFiles'],
                        ['undo', 'redo'],
                    ])
                    ->customTextColors()
                    ->required(),
                Repeater::make('buttons')
                    ->label('Кнопки')
                    ->collapsible()
                    ->schema([
                        TextInput::make('button_title')->label('Название'),
                        TextInput::make('button_link')->label('Ссылка')->url(),
                        FileUpload::make('button_file')
                            ->directory('product')
                            ->disk('public')
                            ->label('Файл')
                    ]),
                Repeater::make('images')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('product')
                            ->disk('public')
                            ->label('Баннер'),
                    ])->collapsible()
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.full-slider.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.full-slider.index', $config)->render();
    }
}
