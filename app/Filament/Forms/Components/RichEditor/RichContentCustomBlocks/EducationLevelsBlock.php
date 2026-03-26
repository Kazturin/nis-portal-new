<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

class EducationLevelsBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'education_levels';
    }

    public static function getLabel(): string
    {
        return 'Уровни образования (Ступени)';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Настройте блок уровней образования')
            ->modalWidth('5xl')
            ->schema([
                Repeater::make('items')
                    ->label('Элементы')
                    ->schema([
                        TextInput::make('range')
                            ->label('Диапазон (например, 1-5)')
                            ->required(),
                        TextInput::make('unit')
                            ->label('Единица (например, классы)')
                            ->default('классы'),
                        TextInput::make('title')
                            ->label('Название образования')
                            ->required(),
                        ColorPicker::make('color')
                            ->label('Цвет фона')
                            ->default('#FDE68A'), // Default yellow
                    ])
                    ->minItems(1)
                    ->maxItems(5)
                    ->columns(2)
                    ->grid(1)
                    ->addActionLabel('Добавить уровень')
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.education-levels.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.education-levels.index', $config)->render();
    }
}
