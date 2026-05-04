<?php

namespace Tests\Feature\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Tests\Traits\SeedsMandatoryWidgets;

class NewsControllerTest extends TestCase
{
    use RefreshDatabase, SeedsMandatoryWidgets;

    protected function setUp(): void
    {
        parent::setUp();
        config(['auth.guards.ldap' => ['driver' => 'session', 'provider' => 'users']]);
        Cache::flush();
        $this->seedMandatoryWidgets();
        
        $user = User::factory()->create(['id' => 1]);
        $this->be($user, 'ldap');
    }

    public function test_news_index_returns_successful_response()
    {
        News::factory()->count(15)->create(['active' => true]);

        $response = $this->get('/kk/news');

        $response->assertStatus(200);
        $response->assertViewHas('news');
    }

    public function test_news_show_returns_successful_response()
    {
        $news = News::factory()->create([
            'slug' => 'test-news',
            'title_kk' => 'Test News KK',
            'active' => true,
            'views' => 0,
        ]);

        $response = $this->get("/kk/news/{$news->slug}");

        $response->assertStatus(200);
        $response->assertSee('Test News KK');
        
        // Check if views incremented
        $this->assertEquals(1, $news->fresh()->views);
    }

    public function test_news_show_does_not_increment_views_twice_in_session()
    {
        $news = News::factory()->create([
            'slug' => 'test-news-2',
            'active' => true,
            'views' => 0,
        ]);

        // First visit
        $this->get("/kk/news/{$news->slug}");
        $this->assertEquals(1, $news->fresh()->views);

        // Second visit in same session
        $this->get("/kk/news/{$news->slug}");
        $this->assertEquals(1, $news->fresh()->views);
    }

    public function test_news_show_returns_404_for_inactive_news()
    {
        $news = News::factory()->create([
            'slug' => 'inactive-news',
            'active' => false,
        ]);

        $response = $this->get("/kk/news/{$news->slug}");

        $response->assertStatus(404);
    }
}
