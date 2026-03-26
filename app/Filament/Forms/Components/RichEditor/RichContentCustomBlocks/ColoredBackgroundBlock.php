<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;

class ColoredBackgroundBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'colored_background';
    }

    public static function getLabel(): string
    {
        return 'Colored background';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the colored background block')
            ->modalWidth('4xl')
            ->schema([
                ColorPicker::make('color')
                    ->label('Background Color'),
                TextInput::make('title')
                    ->label('Title'),
                RichEditor::make('content')
                    ->label('Content')
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'link', 'textColor', 'alignStart', 'alignCenter', 'alignEnd'],
                        ['h4', 'h5', 'h6', 'bulletList', 'orderedList', 'attachFiles'],
                        ['undo', 'redo'],
                    ])
                    ->customTextColors()
                    ->required(),
                Fieldset::make('Дизайн')
                    ->schema([
                        TextInput::make('padding')
                            ->label('Padding')
                            ->suffix('px'),
                        TextInput::make('border_radius')
                            ->label('Border radius')
                            ->suffix('px'),
                        TextInput::make('width')
                            ->label('Width')
                            ->default(100)
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(100)
                            ->suffix('%'),
                    ])
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.colored-background.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.colored-background.index', $config)->render();
    }
}
