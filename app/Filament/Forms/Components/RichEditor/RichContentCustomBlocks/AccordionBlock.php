<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Filament\Forms\Components\TextInput;

class AccordionBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'accordion';
    }

    public static function getLabel(): string
    {
        return 'Аккордион (Details)';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Настройка блока аккордиона')
            ->modalWidth('5xl')
            ->schema([
                Repeater::make('items')
                    ->label('Элементы аккордиона')
                    ->schema([
                        TextInput::make('title')
                            ->label('Заголовок (Summary)')
                            ->required(),
                        RichEditor::make('content')
                            ->label('Содержимое')
                            ->required()
                            ->toolbarButtons([
                                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
                                ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                ['table', 'attachFiles', 'grid', 'customBlocks'],
                                ['undo', 'redo'],
                            ])
                            ->customTextColors()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('pages/content/attachments')
                            ->json()
                            ->customBlocks([
                                PrimaryLinkBlock::class,
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
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.accordion.preview', [
            'items' => $config['items'] ?? [],
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        $items = array_map(function ($item) {
            if (isset($item['content'])) {
                $item['content'] = RichContentRenderer::make($item['content'])
                    ->fileAttachmentsDisk('public')
                    ->customBlocks([
                        PrimaryLinkBlock::class,
                    ])
                    ->toUnsafeHtml();
            }
            return $item;
        }, $config['items'] ?? []);

        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.accordion.index', [
            'items' => $items,
        ])->render();
    }
}
