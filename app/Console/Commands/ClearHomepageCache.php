<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearHomepageCache extends Command
{
    protected $signature = 'cache:clear-homepage';
    protected $description = 'Clear the cached homepage HTML for all locales';

    public function handle(): int
    {
        foreach (['kk', 'ru', 'en'] as $locale) {
            Cache::forget("homepage_html_{$locale}");
        }

        $this->info('Homepage HTML cache cleared for all locales.');

        return self::SUCCESS;
    }
}
