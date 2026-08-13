<?php

namespace App\Filament\Forms\Components\RichEditor\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\EditorCommand;
use Filament\Support\Enums\Width;

class TableCellBgColorAction
{
    public static function make(): Action
    {
        return Action::make('tableCellBgColor')
            ->label('Цвет фона ячейки')
            ->modalHeading('Настройка цвета фона ячейки')
            ->modalWidth(Width::Small)
            ->fillForm(fn (array $arguments): ?array => [
                'color' => $arguments['color'] ?? null,
            ])
            ->schema(function () {
                return [
                    ColorPicker::make('color')
                        ->label('Цвет')
                ];
            })
            ->action(function (array $arguments, array $data, RichEditor $component): void {
                $color = $data['color'] ?? null;

                if (blank($color)) {
                    $component->runCommands(
                        [
                            EditorCommand::make(
                                'setCellAttribute',
                                arguments: ['backgroundColor', null],
                            ),
                        ],
                        editorSelection: $arguments['editorSelection'],
                    );

                    return;
                }

                $component->runCommands(
                    [
                        EditorCommand::make(
                            'setCellAttribute',
                            arguments: ['backgroundColor', $color],
                        ),
                    ],
                    editorSelection: $arguments['editorSelection'],
                );
            });
    }
}
