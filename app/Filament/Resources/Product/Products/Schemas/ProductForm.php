<?php

namespace App\Filament\Resources\Product\Products\Schemas;

use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\BorderedTextBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\CheckListBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\ColoredBackgroundBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\FullSliderBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\GallerySliderBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\HorizontalCardBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\ImageBottomTextBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\ImageWithOverlayBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\KeyBenefitsBlock;
use App\Models\Menu;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->schema([
                        Select::make('menu_id')
                            ->required()
                            ->label('Меню')
                            ->options(Menu::query()->where('is_product', true)->pluck('title_ru', 'id')),
                        Tabs::make('')
                            ->tabs([
                                Tabs\Tab::make('kz')
                                    ->schema([
                                        static::getCopyActions("kk"),
                                        TextInput::make('title_kk')
                                            ->required()
                                            ->maxLength(255),
                                        RichEditor::make('content_kk')
                                            ->required()
                                            ->toolbarButtons([
                                                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
                                                ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'alignStart', 'alignCenter', 'alignEnd'],
                                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                                ['table', 'attachFiles', 'grid', 'customBlocks'],
                                                ['undo', 'redo'],
                                            ])
                                            ->customTextColors()
                                            ->customBlocks([
                                                KeyBenefitsBlock::class,
                                                ImageBottomTextBlock::class,
                                                FullSliderBlock::class,
                                                HorizontalCardBlock::class,
                                                GallerySliderBlock::class,
                                                ImageWithOverlayBlock::class,
                                                BorderedTextBlock::class,
                                                ColoredBackgroundBlock::class,
                                                CheckListBlock::class,
                                            ])
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('pages/content/attachments')
                                            ->fileAttachmentsAcceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                            ->json()
                                            ->extraInputAttributes([
                                                'style' => 'max-height: 50vh; overflow-y: auto;',
                                            ]),
                                    ]),
                                Tabs\Tab::make('ru')
                                    ->schema([
                                        static::getCopyActions("ru"),
                                        TextInput::make('title_ru')
                                            ->required()
                                            ->maxLength(255),
                                        RichEditor::make('content_ru')
                                            ->required()
                                            ->toolbarButtons([
                                                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
                                                ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'alignStart', 'alignCenter', 'alignEnd'],
                                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                                ['table', 'attachFiles', 'grid', 'customBlocks'],
                                                ['undo', 'redo'],
                                            ])
                                            ->customTextColors()
                                            ->customBlocks([
                                                KeyBenefitsBlock::class,
                                                ImageBottomTextBlock::class,
                                                FullSliderBlock::class,
                                                HorizontalCardBlock::class,
                                                GallerySliderBlock::class,
                                                ImageWithOverlayBlock::class,
                                                BorderedTextBlock::class,
                                                ColoredBackgroundBlock::class,
                                                CheckListBlock::class,
                                            ])
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('pages/content/attachments')
                                            ->fileAttachmentsAcceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                            ->json()
                                            ->extraInputAttributes([
                                                'style' => 'max-height: 50vh; overflow-y: auto;',
                                            ]),
                                    ]),
                                Tabs\Tab::make('en')
                                    ->schema([
                                        static::getCopyActions("en"),
                                        TextInput::make('title_en')
                                            ->maxLength(255),
                                        RichEditor::make('content_en')
                                            ->toolbarButtons([
                                                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
                                                ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'alignStart', 'alignCenter', 'alignEnd'],
                                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                                ['table', 'attachFiles', 'grid', 'customBlocks'],
                                                ['undo', 'redo'],
                                            ])
                                            ->customTextColors()
                                            ->customBlocks([
                                                KeyBenefitsBlock::class,
                                                ImageBottomTextBlock::class,
                                                FullSliderBlock::class,
                                                HorizontalCardBlock::class,
                                                GallerySliderBlock::class,
                                                ImageWithOverlayBlock::class,
                                                BorderedTextBlock::class,
                                                ColoredBackgroundBlock::class,
                                                CheckListBlock::class,
                                            ])
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('pages/content/attachments')
                                            ->fileAttachmentsAcceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                            ->json()
                                            ->extraInputAttributes([
                                                'style' => 'max-height: 50vh; overflow-y: auto;',
                                            ]),
                                    ])
                            ]),
                        Toggle::make('active')
                            ->label('Активный')
                            ->default(1),
                        Fieldset::make('Форма')
                            ->relationship('formSchema', condition: fn(?array $state): bool => filled($state['title_kk'] ?? null))
                            ->schema([
                                Tabs::make('')
                                    ->tabs([
                                        Tabs\Tab::make('kz')
                                            ->schema([
                                                TextInput::make('title_kk')
                                                    ->requiredWith('title_kk')
                                                    ->label('Название формы(kz)'),
                                                TextInput::make('submit_label_kk')
                                                    ->requiredWith('title_kk')
                                                    ->label('Название кнопки(kz)'),
                                            ]),
                                        Tabs\Tab::make('ru')
                                            ->schema([
                                                TextInput::make('title_ru')
                                                    ->requiredWith('title_kk')
                                                    ->label('Название формы(ru)'),
                                                TextInput::make('submit_label_ru')
                                                    ->requiredWith('title_kk')
                                                    ->label('Название кнопки(ru)'),
                                            ]),
                                        Tabs\Tab::make('en')
                                            ->schema([
                                                TextInput::make('title_en')
                                                    ->requiredWith('title_kk')
                                                    ->label('Название формы(en)'),
                                                TextInput::make('submit_label_en')
                                                    ->requiredWith('title_kk')
                                                    ->label('Название кнопки(en)'),
                                            ])
                                    ]),

                                Repeater::make('form_schema')
                                    ->schema([
                                        TextInput::make('name_kk')
                                            ->requiredWith('title_kk')
                                            ->label('Название поля(kz)'),
                                        TextInput::make('name_ru')
                                            ->requiredWith('title_kk')
                                            ->label('Название поля(ru)'),
                                        TextInput::make('name_en')
                                            ->requiredWith('title_kk')
                                            ->label('Название поля(en)'),
                                        Select::make('type')
                                            ->options([
                                                'text' => 'Текст',
                                                'email' => 'Email',
                                                'tel' => 'Телефон',
                                            ])
                                            ->requiredWith('title_kk')
                                            ->label('Тип поля'),
                                    ])
                                    ->addActionLabel('Добавить поле')
                                    ->label('Настроить форму')
                                    ->collapsed(),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
    protected static function getCopyActions(string $targetLang): Actions
    {
        return Actions::make([
            Action::make("copy_kk_to_{$targetLang}")
                ->label("Скопировать из KZ")
                ->icon('heroicon-m-clipboard-document-check')
                ->color('gray')
                ->requiresConfirmation()
                ->hidden($targetLang === 'kk')
                ->action(function (Get $get, Set $set) use ($targetLang) {
                    $set("title_{$targetLang}", $get("title_kk"));
                    $set("content_{$targetLang}", $get("content_kk"));
                    $set("meta_title_{$targetLang}", $get("meta_title_kk"));
                    $set("meta_description_{$targetLang}", $get("meta_description_kk"));
                }),
            Action::make("copy_ru_to_{$targetLang}")
                ->label("Скопировать из RU")
                ->icon('heroicon-m-clipboard-document-check')
                ->color('gray')
                ->requiresConfirmation()
                ->hidden($targetLang === 'ru')
                ->action(function (Get $get, Set $set) use ($targetLang) {
                    $set("title_{$targetLang}", $get("title_ru"));
                    $set("content_{$targetLang}", $get("content_ru"));
                    $set("meta_title_{$targetLang}", $get("meta_title_ru"));
                    $set("meta_description_{$targetLang}", $get("meta_description_ru"));
                }),
            Action::make("copy_en_to_{$targetLang}")
                ->label("Скопировать из EN")
                ->icon('heroicon-m-clipboard-document-check')
                ->color('gray')
                ->requiresConfirmation()
                ->hidden($targetLang === 'en')
                ->action(function (Get $get, Set $set) use ($targetLang) {
                    $set("title_{$targetLang}", $get("title_en"));
                    $set("content_{$targetLang}", $get("content_en"));
                    $set("meta_title_{$targetLang}", $get("meta_title_en"));
                    $set("meta_description_{$targetLang}", $get("meta_description_en"));
                }),
        ])->alignEnd();
    }
}
