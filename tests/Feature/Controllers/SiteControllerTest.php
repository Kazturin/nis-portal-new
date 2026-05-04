<?php

namespace Tests\Feature\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SiteControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        $user = User::factory()->create(['id' => 1]);
        $this->be($user);
    }

    protected function seedHomepageData()
    {
        News::factory()->count(5)->create(['active' => true]);
        \App\Models\Advantage::factory()->count(3)->create(['active' => true]);
        \App\Models\Ad::factory()->count(2)->create(['active' => true]);
        
        // Seed mandatory widgets required by Layout component and Homepage
        $mandatoryWidgets = [
            'call_center', 'trademark', 'helpline', 'top_button', 
            'mission', 'opportunities_block', 'resources_block'
        ];
        foreach ($mandatoryWidgets as $key) {
            \Illuminate\Support\Facades\DB::table('text_widgets')->insert([
                'key' => $key,
                'title_kk' => "Title KK $key",
                'title_ru' => "Title RU $key",
                'title_en' => "Title EN $key",
                'content_kk' => "Content KK $key",
                'content_ru' => "Content RU $key",
                'content_en' => "Content EN $key",
                'active' => true,
            ]);
        }

        \App\Models\OtherResource::factory()->count(2)->create(['active' => true]);
        \App\Models\Partner::factory()->count(2)->create();
        
        // Seed statistics with specific keys expected by the view
        $statsKeys = ['17 884', '1891 / 11%', '5 985 / 38,4%', '2702', '20 771', '220', '7,0', '348 465', '91,8 %', '22', '1299'];
        foreach ($statsKeys as $key) {
            \Illuminate\Support\Facades\DB::table('statistics')->insert([
                'value' => $key,
                'description_kk' => "Stats KK $key",
                'description_ru' => "Stats RU $key",
                'description_en' => "Stats EN $key",
            ]);
        }
    }

    public function test_homepage_returns_successful_response()
    {
        $this->seedHomepageData();

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_homepage_is_cached()
    {
        $this->seedHomepageData();
        $locale = app()->getLocale();
        $cacheKey = "homepage_html_{$locale}";

        $this->assertFalse(Cache::has($cacheKey));

        $this->get('/');

        $this->assertTrue(Cache::has($cacheKey));
    }

    public function test_homepage_serves_cached_content()
    {
        $locale = app()->getLocale();
        $cacheKey = "homepage_html_{$locale}";
        Cache::put($cacheKey, 'Cached Homepage Content');

        $response = $this->get('/');

        $response->assertStatus(200);
        $this->assertEquals('Cached Homepage Content', $response->getContent());
    }

    public function test_homepage_respects_locale_cache()
    {
        Cache::put('homepage_html_kk', 'KK Content');
        Cache::put('homepage_html_ru', 'RU Content');

        app()->setLocale('kk');
        $this->get('/')->assertSee('KK Content');

        app()->setLocale('ru');
        $this->get('/')->assertSee('RU Content');
    }
}
