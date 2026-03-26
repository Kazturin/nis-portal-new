<?php

namespace App\Filament\Resources\Pages\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageListRelationManager extends RelationManager
{
    protected static string $relationship = 'pageList';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->schema([
                        Tabs::make('Tabs')
                            ->tabs([
                                Tabs\Tab::make('kz')
                                    ->schema([
                                        TextInput::make('title_kk')
                                            ->required()
                                            ->maxLength(255),
                                        RichEditor::make('description_kk')
                                            ->toolbarButtons([
                                                ['bold', 'italic', 'underline', 'link', 'textColor'],
                                                ['h4', 'h5', 'h6', 'bulletList', 'orderedList'],
                                                ['undo', 'redo'],
                                            ])
                                            ->customTextColors()
                                            ->columnSpanFull(),
                                        RichEditor::make('content_kk')
                                            ->columnSpanFull(),
                                    ]),
                                Tabs\Tab::make('ru')
                                    ->schema([
                                        TextInput::make('title_ru')
                                            ->required()
                                            ->maxLength(255),
                                        RichEditor::make('description_ru')
                                            ->toolbarButtons([
                                                ['bold', 'italic', 'underline', 'link', 'textColor'],
                                                ['h4', 'h5', 'h6', 'bulletList', 'orderedList'],
                                                ['undo', 'redo'],
                                            ])
                                            ->customTextColors()
                                            ->columnSpanFull(),
                                        RichEditor::make('content_ru')
                                            ->columnSpanFull(),
                                    ]),
                                Tabs\Tab::make('en')
                                    ->schema([
                                        TextInput::make('title_en')
                                            ->maxLength(255),
                                        RichEditor::make('description_en')
                                            ->toolbarButtons([
                                                ['bold', 'italic', 'underline', 'link', 'textColor'],
                                                ['h4', 'h5', 'h6', 'bulletList', 'orderedList'],
                                                ['undo', 'redo'],
                                            ])
                                            ->customTextColors()
                                            ->columnSpanFull(),
                                        RichEditor::make('content_en')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        TextInput::make('position')
                            ->required()
                            ->numeric()
                            ->default(0),
                        DateTimePicker::make('date'),
                        FileUpload::make('image')
                            ->directory('page_list')
                            ->disk('public')
                            ->image(),
                        Toggle::make('active')
                            ->default(1),
                    ])->columnSpanFull(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title_kk'),
                TextEntry::make('title_ru'),
                TextEntry::make('title_en')
                    ->placeholder('-'),
                TextEntry::make('description_kk')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description_ru')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description_en')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('content_kk')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('content_ru')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('content_en')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('date')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('position')
                    ->numeric(),
                ImageEntry::make('image')
                    ->placeholder('-'),
                IconEntry::make('active')
                    ->boolean(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title_kk')
            ->columns([
                TextColumn::make('title_ru')
                    ->label('Заголовок'),
                TextColumn::make('created_at')
                    ->label('Дата'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
