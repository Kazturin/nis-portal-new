<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class PrimaryLinkBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'primary_link';
    }

    public static function getLabel(): string
    {
        return 'Primary link';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the primary link block')
            ->schema([
                TextInput::make('url')
                    ->label('URL'),
                TextInput::make('button_text')
                    ->label('Button text'),
                Select::make('target')
                    ->label('Target')
                    ->options([
                        '_self' => 'Self',
                        '_blank' => 'Blank',
                    ])
                    ->default('_self'),
                Select::make('position')
                    ->label('Position')
                    ->options([
                        'left' => 'Left',
                        'center' => 'Center',
                        'right' => 'Right',
                    ])
                    ->default('left'),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.primary-link.preview', $config)->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.primary-link.index', $config)->render();
    }
}
