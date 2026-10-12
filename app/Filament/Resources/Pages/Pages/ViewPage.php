<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use App\Models\Page;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPage extends ViewRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewFrontend')
                ->label('Открыть на сайте')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (Page $record): string => route('page', ['locale' => app()->getLocale(), 'page' => $record]))
                ->openUrlInNewTab(),
            EditAction::make(),
        ];
    }
}
