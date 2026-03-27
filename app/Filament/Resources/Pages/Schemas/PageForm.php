<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Enums\ListViewType;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\AnimatedNumbersBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\ColoredBackgroundBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\ContactBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\CurriculumCardBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\CurriculumResultBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\EducationLevelsBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\FixedButtonBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\FullSliderBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\GallerySliderBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\HorizontalCardBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\OrnamentCardBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\TextSliderBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\VerticalCardBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\WorldMapBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\YoutubeBlock;
use App\Models\Menu;
use App\Models\Page;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Actions\Action;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Validation\Rules\Unique;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {

        $menuOptions = Menu::query()->with('parent')
            ->get()
            ->map(function (\App\Models\Menu $menu) {
                return [
                    'id' => $menu->id,
                    'title' => $menu->parent ? $menu->parent->title_ru . ' > ' . $menu->title_ru : $menu->title_ru,
                ];
            });


        return $schema
            ->components([
                Section::make('')
                    ->schema([
                        Tabs::make('Tabs')
                            ->tabs([
                                Tabs\Tab::make('kz')
                                    ->schema([
                                        static::getCopyActions("kk"),
                                        TextInput::make('title_kk')
                                            ->label('Заголовок(kz)')
                                            ->required()
                                            ->maxLength(255)
                                            ->reactive()
                                            ->debounce(500),
                                        RichEditor::make('content_kk')
                                            ->label("Содержимое")
                                            ->customBlocks([
                                                WorldMapBlock::class,
                                                YoutubeBlock::class,
                                                AnimatedNumbersBlock::class,
                                                ContactBlock::class,
                                                FullSliderBlock::class,
                                                GallerySliderBlock::class,
                                                HorizontalCardBlock::class,
                                                VerticalCardBlock::class,
                                                OrnamentCardBlock::class,
                                                TextSliderBlock::class,
                                                EducationLevelsBlock::class,
                                                CurriculumCardBlock::class,
                                                CurriculumResultBlock::class,
                                                ColoredBackgroundBlock::class,
                                                FixedButtonBlock::class,
                                            ])
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
                                            ->label('Заголовок(ru)')
                                            ->required()
                                            ->maxLength(255),
                                        RichEditor::make("content_ru")
                                            ->label("Содержимое")
                                            ->customBlocks([
                                                WorldMapBlock::class,
                                                YoutubeBlock::class,
                                                AnimatedNumbersBlock::class,
                                                ContactBlock::class,
                                                FullSliderBlock::class,
                                                GallerySliderBlock::class,
                                                HorizontalCardBlock::class,
                                                VerticalCardBlock::class,
                                                OrnamentCardBlock::class,
                                                TextSliderBlock::class,
                                                EducationLevelsBlock::class,
                                                CurriculumCardBlock::class,
                                                CurriculumResultBlock::class,
                                                ColoredBackgroundBlock::class,
                                                FixedButtonBlock::class,
                                            ])
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
                                            ->label('Заголовок(en)')
                                            ->required()
                                            ->maxLength(255),
                                        RichEditor::make('content_en')
                                            ->required()
                                            ->label("Содержимое")
                                            ->customBlocks([
                                                WorldMapBlock::class,
                                                YoutubeBlock::class,
                                                AnimatedNumbersBlock::class,
                                                ContactBlock::class,
                                                FullSliderBlock::class,
                                                GallerySliderBlock::class,
                                                HorizontalCardBlock::class,
                                                VerticalCardBlock::class,
                                                OrnamentCardBlock::class,
                                                TextSliderBlock::class,
                                                EducationLevelsBlock::class,
                                                CurriculumCardBlock::class,
                                                CurriculumResultBlock::class,
                                                ColoredBackgroundBlock::class,
                                                FixedButtonBlock::class,
                                            ])
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
                                            ->fileAttachmentsAcceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                            ->json()
                                            ->extraInputAttributes([
                                                'style' => 'max-height: 50vh; overflow-y: auto;',
                                            ]),
                                    ]),
                            ]),

                        Select::make('menu_id')
                            ->required()
                            ->label('Меню')
                            ->options($menuOptions->pluck('title', 'id'))
                            ->searchable()
                            ->unique('pages', ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'Такая страница уже существует.',
                            ]),

                        Select::make('parent_id')
                            ->label('Родительский страница')
                            ->options(Page::query()->pluck('title_ru', 'id'))
                            ->searchable(),
                        Select::make('lists_view_type')
                            ->label('Шаблон отображения списков')
                            ->options(collect(ListViewType::cases())->mapWithKeys(fn($case) => [
                                $case->value => $case->name,
                            ])->toArray()),
                        Toggle::make('active')
                            ->label('Активна')
                            ->default(1),
                        // Toggle::make('is_protected')
                        //     ->label('Защищенная страница')
                        //     ->default(0),
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
