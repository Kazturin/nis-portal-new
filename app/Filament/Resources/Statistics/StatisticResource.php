<?php

namespace App\Filament\Resources\Statistics;

use App\Filament\Resources\Statistics\Pages\ManageStatistics;
use App\Models\Statistic;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StatisticResource extends Resource
{
    protected static ?string $model = Statistic::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationLabel = 'Статистика';

    protected static ?string $modelLabel = 'Показатель статистики';

    protected static ?string $pluralModelLabel = 'Статистика';

    protected static ?string $recordTitleAttribute = 'value';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('value')
                    ->label('Значение')
                    ->nullable()
                    ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? $state : null)
                    ->maxLength(20)
                    ->columnSpanFull(),
                TextInput::make('sort')
                    ->label('Порядок')
                    ->helperText('Показатели выводятся по возрастанию этого числа.')
                    ->integer()
                    ->minValue(0)
                    ->maxValue(4294967295)
                    ->default(fn (): int => ((int) Statistic::max('sort')) + 1)
                    ->required(),
                Tabs::make('Описания')
                    ->tabs([
                        Tabs\Tab::make('KZ')
                            ->schema([
                                RichEditor::make('description_kk')
                                    ->label('Контент(KZ)')
                                    ->toolbarButtons([
                                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
                                        ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                                        ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                        ['table', 'attachFiles', 'grid', 'customBlocks'],
                                        ['undo', 'redo'],
                                    ])
                                    ->customTextColors()
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('RU')
                            ->schema([
                                RichEditor::make('description_ru')
                                    ->label('Контент(RU)')
                                    ->toolbarButtons([
                                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
                                        ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                                        ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                        ['table', 'attachFiles', 'grid', 'customBlocks'],
                                        ['undo', 'redo'],
                                    ])
                                    ->customTextColors()
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('EN')
                            ->schema([
                                RichEditor::make('description_en')
                                    ->label('Контент(EN)')
                                    ->toolbarButtons([
                                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
                                        ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                                        ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                        ['table', 'attachFiles', 'grid', 'customBlocks'],
                                        ['undo', 'redo'],
                                    ])
                                    ->customTextColors()
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort')
            ->columns([
                TextColumn::make('sort')
                    ->label('Порядок')
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Значение')
                    ->placeholder('—')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description_kk')
                    ->label('Описание (KZ)')
                    ->formatStateUsing(fn (string $state): string => strip_tags($state))
                    ->limit(80)
                    ->wrap()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('description_ru')
                    ->label('Описание (RU)')
                    ->formatStateUsing(fn (string $state): string => strip_tags($state))
                    ->limit(80)
                    ->wrap()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('description_en')
                    ->label('Описание (EN)')
                    ->formatStateUsing(fn (string $state): string => strip_tags($state))
                    ->limit(80)
                    ->wrap()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Обновлён')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getPages(): array
    {
        return [
            'index' => ManageStatistics::route('/'),
        ];
    }
}
