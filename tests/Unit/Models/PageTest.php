<?php

namespace Tests\Unit\Models;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_top_parent_menu()
    {
        $rootMenu = Menu::factory()->create(['title_kk' => 'Root', 'position' => Menu::POSITION_HEADER]);
        $childMenu = Menu::factory()->create(['parent_id' => $rootMenu->id]);
        $grandChildMenu = Menu::factory()->create(['parent_id' => $childMenu->id]);

        $page = Page::factory()->create([
            'menu_id' => $grandChildMenu->id,
        ]);

        $this->assertEquals($rootMenu->id, $page->getTopParentMenu());
    }

    public function test_cache_is_invalidated_on_save()
    {
        Cache::shouldReceive('forget')->atLeast()->once();
        
        $page = Page::factory()->create();
        $page->title_kk = 'Updated Title';
        $page->save();
    }

    public function test_get_url_attribute()
    {
        $page = Page::factory()->make(['slug' => 'test-page']);
        $this->assertStringContainsString('/page/test-page', $page->url);
    }
}
