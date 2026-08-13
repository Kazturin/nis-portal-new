<?php

namespace App\Filament\Forms\Components\RichEditor\Plugins;

use App\Filament\Forms\Components\RichEditor\Actions\TableCellBgColorAction;
use Filament\Forms\Components\RichEditor\Plugins\Contracts\RichContentPlugin;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Vite;

class TableColorPlugin implements RichContentPlugin
{
    public function getTipTapPhpExtensions(): array
    {
        return [
            new \App\Filament\Forms\Components\RichEditor\Extensions\CustomTableCell(),
            new \App\Filament\Forms\Components\RichEditor\Extensions\CustomTableHeader(),
        ];
    }

    public function getTipTapJsExtensions(): array
    {
        return [
            Vite::asset('resources/js/filament/rich-editor-table-cell-bg.js'),
            Vite::asset('resources/js/filament/rich-editor-table-header-bg.js'),
        ];
    }

    public function getEditorTools(): array
    {
        return [
            RichEditorTool::make('tableCellBgColor')
                ->label('Цвет фона ячейки')
                ->icon(Heroicon::OutlinedPaintBrush)
                ->action(arguments: '{ color: $getEditor().getAttributes(\'tableCell\')[\'backgroundColor\'] ?? $getEditor().getAttributes(\'tableHeader\')[\'backgroundColor\'] ?? null }')
        ];
    }

    public function getEditorActions(): array
    {
        return [
            TableCellBgColorAction::make(),
        ];
    }
}
