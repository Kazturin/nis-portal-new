<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;

class CheckListBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'check_list';
    }

    public static function getLabel(): string
    {
        return 'Check list';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the check list block')
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->label('Заголовок'),
                Fieldset::make('Ссылка')
                    ->schema([
                        TextInput::make('link_text')
                            ->required(),
                        TextInput::make('link')
                            ->required(),
                    ]),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('product/advantages')
                    ->label('Картинка'),
                Repeater::make('items')
                    ->label('Пункты списка')
                    ->schema([
                        TextInput::make('text')
                            ->required()
                            ->label('Текст пункта'),
                    ]),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.check-list.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.check-list.index', $config)->render();
    }
}
