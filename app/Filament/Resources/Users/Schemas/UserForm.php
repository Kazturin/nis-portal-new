<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\Rules\Password;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Components\Section;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Имя пользователя')
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->label('Адрес электронной почты')
                    ->maxLength(255),
                TextInput::make('password')
                            ->label(__('Пароль'))
                            ->password()
                            ->revealable()
                            ->required(fn($livewire): bool => $livewire instanceof CreateRecord)
                            ->rule(Password::min(12)
                                ->letters()
                                ->numbers()
                                ->symbols()
                                ->mixedCase()
                                ->uncompromised())
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => bcrypt($state)),
                CheckboxList::make('roles')
                    ->label('Роли')
                    ->columns(3)
                    ->relationship('roles','name'), 
                    ])->columns(2)->columnSpanFull(),
            ]);
    }
}
