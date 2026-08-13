<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use App\Filament\Forms\Components\RichEditor\Plugins\TableColorPlugin;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Illuminate\Support\Str;

class TabsBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'tabs';
    }

    public static function getLabel(): string
    {
        return 'Вкладки (Tabs)';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Настройка блока вкладок')
            ->modalWidth('6xl')
            ->schema([
                Repeater::make('tabs')
                    ->label('Вкладки')
                    ->schema([
                        Hidden::make('id')->default(fn() => Str::random(8)),
                        TextInput::make('title')->label('Заголовок')->required(),
                        RichEditor::make('content')->label('Содержимое')->required()
                            ->toolbarButtons([
                                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
                                ['h2', 'h3', 'h4', 'h5', 'h6', 'alignStart', 'alignCenter', 'alignEnd'],
                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                ['table', 'tableCellBgColor', 'attachFiles', 'grid'],
                                ['undo', 'redo'],
                            ])
                            ->customTextColors()
                            ->plugins([
                                new TableColorPlugin()
                            ]),
                    ])
                    ->collapsible()
                    ->cloneable()
                    ->required()
                    ->minItems(1),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.tabs.preview', [
            'tabs' => $config['tabs'] ?? [],
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        $tabs = array_map(function ($tab) {
            if (isset($tab['content'])) {
                $tab['content'] = RichContentRenderer::make($tab['content'])
                    ->fileAttachmentsDisk('public')
                    ->plugins([
                        new TableColorPlugin(),
                    ])
                    ->customBlocks([
                        PrimaryLinkBlock::class,
                    ])
                    ->toUnsafeHtml();
            }
            if (!isset($tab['id']) || empty($tab['id'])) {
                $tab['id'] = Str::random(8);
            }
            return $tab;
        }, $config['tabs'] ?? []);

        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.tabs.index', [
            'tabs' => $tabs,
        ])->render();
    }
}
