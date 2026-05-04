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
                /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
                $disk = \Illuminate\Support\Facades\Storage::disk($component->getFileAttachmentsDiskName());
                $url = $disk->url($file);
                return preg_replace('/^https?:\/\/[^\/]+/', '', $url);
            });
        });

    }
}
