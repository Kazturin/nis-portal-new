<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait InvalidatesHomepageCache
{
    /**
     * Invalidate the cached homepage HTML for all locales.
     */
    public static function invalidateHomepageHtml(): void
    {
        foreach (['kk', 'ru', 'en'] as $locale) {
            Cache::forget("homepage_html_{$locale}");
        }
    }
}
