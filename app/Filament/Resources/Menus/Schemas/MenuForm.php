<?php

namespace App\Filament\Resources\Menus\Schemas;

use App\Enums\MenuTypeEnum;
use App\Models\Menu;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->schema([
                        Select::make('position')
                            ->label('Тип меню')
                            ->options([
                                Menu::POSITION_HEADER => 'Header',
                                Menu::POSITION_FOOTER => 'Footer'
                            ])
                            ->default(0)
                            ->required(),
                        Radio::make('type')
                            ->options([
                                MenuTypeEnum::PAGE->value => 'Page',
                                MenuTypeEnum::ALUMNI_PAGE->value => 'Alumni Page',
                                MenuTypeEnum::PRODUCT_PAGE->value => 'Product Page'
                            ])
                            ->default(0)
                            ->required(),
                        TextInput::make('title_kk')
                            ->label('Название(kk)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('title_ru')
                            ->label('Название(ru)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('title_en')
                            ->label('Название(en)')
                            ->required()
                            ->maxLength(255)
                            ->reactive()
                            ->debounce(500)
                            ->afterStateUpdated(function (Set $set, $state) {
                                $set('slug', Str::slug($state));
                            }),
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                            'lg' => 3,
                        ])->schema([
                                    TextInput::make('link_kk')
                                        ->label('Ссылка(kk)')
                                        ->maxLength(255),
                                    TextInput::make('link_ru')
                                        ->label('Ссылка(ru)')
                                        ->maxLength(255),
                                    TextInput::make('link_en')
                                        ->label('Ссылка(en)')
                                        ->maxLength(255),
                                ]),
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                            'lg' => 3,
                        ])->schema([
                                    Toggle::make('is_external_link')
                                        ->label('Внешняя ссылка')
                                        ->default(false)
                                        ->default(0),
                                    Toggle::make('open_in_new_tab')
                                        ->label('Открыть в новой вкладке')
                                        ->default(false),
                                ]),
                        TextInput::make('sort')
                            ->label('Позиция')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Select::make('parent_id')
                            ->label('Родитель')
                            ->options(Menu::query()->pluck('title_ru', 'id'))
                            ->searchable(),
                        Toggle::make('active')
                            ->default(1),

                    ])->columnSpan(8),

                Section::make()
                    ->schema([
                        FileUpload::make('banner')
                            ->directory('banner')
                            ->label('Баннер')
                    ])->columnSpan(4)
            ])->columns(12);
    }
}
