<?php

namespace App\Filament\Resources\Pages\RelationManagers;

use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\IframeBlock;
use App\Models\PageList;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use MmesDesign\FilamentFileManager\RichEditor\FileManagerRichEditorPlugin;

class PageListRelationManager extends RelationManager
{
    protected static string $relationship = 'pageList';

    protected static ?string $modelLabel = 'Список';

    protected static ?string $pluralModelLabel = 'Список';

    protected static ?string $title = 'Список';

    private const LANGUAGES = [
        'kk' => 'Казахский',
        'ru' => 'Русский',
        'en' => 'Английский',
    ];

    public function form(Schema $schema): Schema
    {
        $tabs = [];

        foreach (self::LANGUAGES as $locale => $label) {
            $tabs[] = Tabs\Tab::make($label)
                ->schema([
                    TextInput::make("title_{$locale}")
                        ->label('Заголовок')
                        ->required($locale !== 'en')
                        ->maxLength(255),
                    $this->descriptionEditor($locale),
                    $this->contentEditor($locale),
                ]);
        }

        return $schema
            ->components([
                Section::make('Содержимое')
                    ->schema([
                        Tabs::make('Языки')
                            ->tabs($tabs),
                    ])
                    ->columnSpanFull(),
                Section::make('Параметры')
                    ->schema([
                        TextInput::make('position')
                            ->label('Порядок сортировки')
                            ->required()
                            ->numeric()
                            ->default(0),
                        DateTimePicker::make('date')
                            ->label('Дата'),
                        FileUpload::make('image')
                            ->label('Изображение')
                            ->directory('page_list')
                            ->disk('public')
                            ->image(),
                        Toggle::make('active')
                            ->label('Активен')
                            ->default(true),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    private function descriptionEditor(string $locale): RichEditor
    {
        return RichEditor::make("description_{$locale}")
            ->label('Краткое описание')
            ->toolbarButtons([
                ['bold', 'italic', 'underline', 'link', 'textColor'],
                ['h4', 'h5', 'h6', 'bulletList', 'orderedList'],
                ['undo', 'redo'],
            ])
            ->customTextColors()
            ->columnSpanFull();
    }

    private function contentEditor(string $locale): RichEditor
    {
        return RichEditor::make("content_{$locale}")
            ->label('Содержимое')
            ->columnSpanFull()
            ->plugins([
                FileManagerRichEditorPlugin::make()
                    ->multiple(false)
                    ->disk('public')
                    ->directory('pages/list'),
            ])
            ->toolbarButtons([
                ['bold', 'italic', 'underline', 'link', 'textColor'],
                ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                ['blockquote', 'codeBlock', 'bulletList', 'orderedList', 'horizontalRule'],
                ['table', 'attachFiles', 'grid', 'customBlocks'],
                ['undo', 'redo'],
            ])
            ->customBlocks([
                IframeBlock::class,
            ])
            ->enableToolbarButtons(['fileManager'])
            ->json();
    }

    public function infolist(Schema $schema): Schema
    {
        $tabs = [];

        foreach (self::LANGUAGES as $locale => $label) {
            $tabs[] = Tabs\Tab::make($label)
                ->schema([
                    TextEntry::make("title_{$locale}")
                        ->label('Заголовок')
                        ->placeholder('-'),
                    $this->richTextEntry("description_{$locale}", 'Краткое описание'),
                    $this->richTextEntry("content_{$locale}", 'Содержимое'),
                ]);
        }

        return $schema
            ->components([
                Tabs::make('Языки')
                    ->tabs($tabs)
                    ->columnSpanFull(),
                TextEntry::make('date')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->placeholder('-'),
                TextEntry::make('position')
                    ->label('Порядок сортировки')
                    ->numeric(),
                ImageEntry::make('image')
                    ->label('Изображение')
                    ->disk('public')
                    ->placeholder('-'),
                IconEntry::make('active')
                    ->label('Активен')
                    ->boolean(),
            ]);
    }

    private function richTextEntry(string $attribute, string $label): TextEntry
    {
        return TextEntry::make($attribute)
            ->label($label)
            // Convert the entire TipTap document before TextEntry treats arrays as lists.
            ->getStateUsing(function (PageList $record) use ($attribute): ?string {
                $content = $record->getAttribute($attribute);

                if (blank($content)) {
                    return null;
                }

                return RichContentRenderer::make($content)
                    ->fileAttachmentsDisk('public')
                    ->customBlocks([IframeBlock::class])
                    ->toHtml();
            })
            ->html()
            ->prose()
            ->placeholder('-')
            ->columnSpanFull();
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title_kk')
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),
                TextColumn::make('title_ru')
                    ->label('Заголовок'),
                TextColumn::make('date')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->placeholder('-'),
            ])
            ->defaultSort('id', 'desc')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
