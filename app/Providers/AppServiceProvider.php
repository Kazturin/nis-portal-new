<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \Filament\Forms\Components\RichEditor::configureUsing(function (\Filament\Forms\Components\RichEditor $component) {
            $component->getFileAttachmentUrlUsing(function ($file) use ($component) {
                $url = \Illuminate\Support\Facades\Storage::disk($component->getFileAttachmentsDiskName())->url($file);
                return preg_replace('/^https?:\/\/[^\/]+/', '', $url);
            });
        });

        require_once app_path('helpers.php');
    }
}
