<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->schema([
                        Select::make('category_id')
                            ->label('Категория')
                            ->relationship('category', 'title_kk')
                            ->default(1)
                            ->required(),
                        Tabs::make('')
                            ->tabs([
                                Tabs\Tab::make('kz')
                                    ->schema([
                                        TextInput::make('title_kk')
                                            ->label('Заголовок(kz)')
                                            ->required()
                                            ->maxLength(255),
                                        RichEditor::make('content_kk')
                                            ->label('Контент(kz)')
                                            ->required()
                                            ->toolbarButtons([
                                                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
                                                ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'alignStart', 'alignCenter', 'alignEnd'],
                                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                                ['table', 'attachFiles', 'grid', 'customBlocks'],
                                                ['undo', 'redo'],
                                            ])
                                            ->customTextColors()
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('pages/content/attachments')
                                            ->fileAttachmentsAcceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                            ->extraInputAttributes([
                                                'style' => 'max-height: 50vh; overflow-y: auto;',
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                                Tabs\Tab::make('ru')
                                    ->schema([
                                        TextInput::make('title_ru')
                                            ->label('Заголовок(ru)')
                                            ->required()
                                            ->maxLength(255),
                                        RichEditor::make('content_ru')
                                            ->label('Контент(ru)')
                                            ->required()
                                            ->toolbarButtons([
                                                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
                                                ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'alignStart', 'alignCenter', 'alignEnd'],
                                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                                ['table', 'attachFiles', 'grid', 'customBlocks'],
                                                ['undo', 'redo'],
                                            ])
                                            ->customTextColors()
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('pages/content/attachments')
                                            ->fileAttachmentsAcceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                            ->extraInputAttributes([
                                                'style' => 'max-height: 50vh; overflow-y: auto;',
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                                Tabs\Tab::make('en')
                                    ->schema([
                                        TextInput::make('title_en')
                                            ->label('Заголовок(en)')
                                            ->maxLength(255),
                                        RichEditor::make('content_en')
                                            ->label('Контент(en)')
                                            ->toolbarButtons([
                                                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
                                                ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'alignStart', 'alignCenter', 'alignEnd'],
                                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                                ['table', 'attachFiles', 'grid', 'customBlocks'],
                                                ['undo', 'redo'],
                                            ])
                                            ->customTextColors()
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('pages/content/attachments')
                                            ->fileAttachmentsAcceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                            ->extraInputAttributes([
                                                'style' => 'max-height: 50vh; overflow-y: auto;',
                                            ])
                                            ->columnSpanFull(),
                                    ])
                            ]),
                        TextInput::make('meta_title')
                            ->maxLength(255),
                        Textarea::make('meta_description')
                            ->columnSpanFull(),
                        DateTimePicker::make('published_at')
                            ->label('Дата'),
                        Toggle::make('active')
                            ->label('Активный')
                            ->default(1),
                    ])->columnSpan(8),

                Section::make('')
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->image()
                            ->imageEditor()
                            ->imageEditorViewportWidth(1920)
                            ->imageEditorViewportHeight(1080)
                            ->directory('news')
                            ->disk('public')
                            ->label('Картинка'),
                        FileUpload::make('gallery')
                            ->image()
                            ->multiple()
                            ->maxSize(6024)
                            ->label('Галерея')
                            ->disk('public')
                            ->directory('news_gallery'),
                    ])->columnSpan(4)

            ])->columns(12);
    }
}
