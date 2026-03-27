<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class BookAccordionBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'book_accordion';
    }

    public static function getLabel(): string
    {
        return 'Book accordion';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the book accordion block')
            ->modalWidth('5xl')
            ->schema([
                Repeater::make('books')
                    ->label('Книги')
                    ->schema([
                        FileUpload::make('spine_image')
                            ->label('Изображение корешка (Spine)')
                            ->image()
                            ->required()
                            ->disk('public')
                            ->directory('pages/content/attachments'),
                        FileUpload::make('cover_image')
                            ->label('Обложка книги')
                            ->image()
                            ->required()
                            ->disk('public')
                            ->directory('pages/content/attachments'),
                        TextInput::make('title')
                            ->label('Заголовок')
                            ->required(),
                        TextInput::make('subtitle')
                            ->label('Подзаголовок (например, класс)'),
                        Textarea::make('description')
                            ->label('Описание')
                            ->rows(4),
                        TextInput::make('button_text')
                            ->label('Текст кнопки')
                            ->default('Подробнее'),
                        TextInput::make('button_url')
                            ->label('Ссылка кнопки'),
                        Toggle::make('is_active')
                            ->label('Раскрыта по умолчанию')
                            ->default(false),
                    ])
                    ->collapsible()
                    ->cloneable()
                    ->required()
                    ->minItems(1),
                RichEditor::make('footer')
                    ->label('Footer')
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
                        ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                        ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                        ['table', 'attachFiles', 'grid', 'customBlocks'],
                        ['undo', 'redo'],
                    ])
                    ->required(),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.book-accordion.preview', [
            'books' => $config['books'] ?? [],
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.book-accordion.index', [
            'books' => $config['books'] ?? [],
            'footer' => $config['footer'] ?? '',
        ])->render();
    }
}
