<?php

namespace App\Filament\Resources\Pages\RelationManagers;

use App\Models\PageFile;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FilesRelationManager extends RelationManager
{
    protected static string $relationship = 'files';

    protected static ?string $title = 'Файлы';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->schema([
                        Tabs::make('Языки')
                            ->tabs([
                                Tabs\Tab::make('Казахский')
                                    ->schema([
                                        TextInput::make('title_kk')
                                            ->label('Заголовок')
                                            ->maxLength(255),

                                        FileUpload::make('files_kk')
                                            ->disk('public')
                                            ->directory('files')
                                            ->multiple()
                                            ->reorderable()
                                            ->label('Файлы'),
                                        TextInput::make('link_kk')
                                            ->maxLength(255)
                                            ->label('Ссылка'),
                                    ]),
                                Tabs\Tab::make('Русский')
                                    ->schema([
                                        TextInput::make('title_ru')
                                            ->label('Заголовок')
                                            ->maxLength(255),

                                        FileUpload::make('files_ru')
                                            ->disk('public')
                                            ->directory('files')
                                            ->multiple()
                                            ->reorderable()
                                            ->label('Файлы'),
                                        TextInput::make('link_ru')
                                            ->label('Ссылка')
                                            ->maxLength(255),
                                    ]),
                                Tabs\Tab::make('Английский')
                                    ->schema([
                                        TextInput::make('title_en')
                                            ->label('Заголовок')
                                            ->maxLength(255),

                                        FileUpload::make('files_en')
                                            ->disk('public')
                                            ->directory('files')
                                            ->multiple()
                                            ->reorderable()
                                            ->label('Файлы'),
                                        TextInput::make('link_en')
                                            ->label('Ссылка')
                                            ->maxLength(255),
                                    ]),
                            ]),
                        TextInput::make('position')
                            ->label('Порядок сортировки')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])->columnSpan(8),

                Section::make('')
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->image()
                            ->directory('files/thumbnail')
                            ->label('Обложка'),
                    ])->columnSpan(4),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title_ru')
            ->columns([
                TextColumn::make('title_ru')
                    ->label('Заголовок'),
                TextColumn::make('files_ru')
                    ->label('Файлы')
                    ->url(function (PageFile $pageFile) {
                        foreach ($pageFile->files_ru as $file) {
                            return '/storage/'.$file;
                        }

                    }, true)
                    ->formatStateUsing(function (PageFile $pageFile) {
                        return implode(', ', $pageFile->files_ru);
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
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
