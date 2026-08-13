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
                        Tabs::make('tabs')
                            ->tabs([
                                Tabs\Tab::make('kz')
                                    ->schema([
                                        TextInput::make('title_kk')->label('Заголовок (KZ)')->required(),
                                        RichEditor::make('content_kk')->label('Содержимое (KZ)')->required()
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
                                    ]),
                                Tabs\Tab::make('ru')
                                    ->schema([
                                        TextInput::make('title_ru')->label('Заголовок (RU)')->required(),
                                        RichEditor::make('content_ru')->label('Содержимое (RU)')->required()
                                            ->toolbarButtons([
                                                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
                                                ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                                ['table', 'tableCellBgColor', 'attachFiles', 'grid'],
                                                ['undo', 'redo'],
                                            ])
                                            ->customTextColors()
                                            ->plugins([
                                                new TableColorPlugin()
                                            ]),
                                    ]),
                                Tabs\Tab::make('en')
                                    ->schema([
                                        TextInput::make('title_en')->label('Заголовок (EN)')->required(),
                                        RichEditor::make('content_en')->label('Содержимое (EN)')->required()
                                            ->toolbarButtons([
                                                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
                                                ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                                ['table', 'tableCellBgColor', 'attachFiles', 'grid'],
                                                ['undo', 'redo'],
                                            ])
                                            ->customTextColors()
                                            ->plugins([
                                                new TableColorPlugin()
                                            ]),
                                    ]),
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
            foreach (['kk', 'ru', 'en'] as $lang) {
                if (isset($tab['content_' . $lang])) {
                    $tab['content_' . $lang] = RichContentRenderer::make($tab['content_' . $lang])
                        ->fileAttachmentsDisk('public')
                        ->plugins([
                            new TableColorPlugin(),
                        ])
                        ->customBlocks([
                            PrimaryLinkBlock::class,
                        ])
                        ->toUnsafeHtml();
                }
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
