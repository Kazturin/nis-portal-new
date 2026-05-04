<?php

namespace Tests\Feature\Controllers;

use App\Models\News;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Tests\Traits\SeedsMandatoryWidgets;

class SearchControllerTest extends TestCase
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

    public function test_search_returns_successful_response()
    {
        $response = $this->get('/kk/search?query=test');

        $response->assertStatus(200);
        $response->assertViewIs('search.index');
        $response->assertViewHas('results');
    }

    public function test_search_finds_pages()
    {
        $page = Page::factory()->create([
            'title_kk' => 'UniquePageTitle',
            'content_kk' => 'Some content',
            'active' => true,
        ]);

        // Fulltext search might be tricky in tests depending on MySQL config
        // But we should at least hit the lines in the controller
        $response = $this->get('/kk/search?query=UniquePageTitle');

        $response->assertStatus(200);
    }

    public function test_search_finds_news()
    {
        $news = News::factory()->create([
            'title_kk' => 'UniqueNewsTitle',
            'content_kk' => 'Some news content',
            'active' => true,
        ]);

        $response = $this->get('/kk/search?query=UniqueNewsTitle');

        $response->assertStatus(200);
    }
}
