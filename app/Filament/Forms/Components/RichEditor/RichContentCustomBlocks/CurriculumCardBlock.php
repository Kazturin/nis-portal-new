<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

class CurriculumCardBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'curriculum_card';
    }

    public static function getLabel(): string
    {
        return 'Карточка программы (с ярлыком)';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Настройте карточку программы')
            ->modalWidth('2xl')
            ->schema([
                TextInput::make('top_label')
                    ->label('Текст сверху (Ярлык)')
                    ->placeholder('Например: На казахском'),
                ColorPicker::make('background_color')
                    ->label('Цвет фона')
                    ->default('#BEE98F'),
                RichEditor::make('content')
                    ->label('Содержимое')
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'link', 'textColor'],
                        ['bulletList', 'orderedList'],
                        ['undo', 'redo'],
                    ])
                    ->required(),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.curriculum-card.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.curriculum-card.index', $config)->render();
    }
}
