<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

class CurriculumResultBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'curriculum_result';
    }

    public static function getLabel(): string
    {
        return 'Результат программы (C1/Badge)';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Настройте плашку результата')
            ->modalWidth('2xl')
            ->schema([
                TextInput::make('badge_text')
                    ->label('Текст бейджа')
                    ->default('C1')
                    ->required(),
                ColorPicker::make('badge_color')
                    ->label('Цвет бейджа')
                    ->default('#BEE98F'),
                TextInput::make('description')
                    ->label('Текст результата')
                    ->default('Ожидаемые уровни на выходе по шкале CEFR')
                    ->required(),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.curriculum-result.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.curriculum-result.index', $config)->render();
    }
}
