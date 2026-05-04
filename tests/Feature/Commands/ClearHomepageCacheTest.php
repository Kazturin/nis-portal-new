<?php

namespace Tests\Feature\Commands;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ClearHomepageCacheTest extends TestCase
{
    public function test_it_clears_homepage_cache_for_all_locales()
    {
        Cache::shouldReceive('forget')
            ->once()
            ->with('homepage_html_kk');
        
        Cache::shouldReceive('forget')
            ->once()
            ->with('homepage_html_ru');
            
        Cache::shouldReceive('forget')
            ->once()
            ->with('homepage_html_en');

        $this->artisan('cache:clear-homepage')
            ->expectsOutput('Homepage HTML cache cleared for all locales.')
            ->assertExitCode(0);
    }
}
