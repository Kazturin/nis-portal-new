<?php

namespace Tests\Unit\Models;

use App\Models\Menu;
use App\Models\Page;
use App\Models\Product\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_banner_returns_default()
    {
        $menu = Menu::factory()->make(['banner' => null]);
        $this->assertEquals('/img/page_banner.png', $menu->getBanner());
    }

    public function test_get_banner_returns_storage_path()
    {
        $menu = Menu::factory()->make(['banner' => 'menus/banner.png']);
        $this->assertEquals('/storage/menus/banner.png', $menu->getBanner());
    }

    public function test_get_url_for_product()
    {
        $menu = Menu::factory()->create();
        $product = Product::factory()->create([
            'title_kk' => 'Unique Product Title',
            'menu_id' => $menu->id
        ]);

        $url = $menu->getUrl();
        $this->assertStringContainsString($product->slug, $url);
    }

    public function test_get_url_for_external_link()
    {
        $menu = Menu::factory()->make([
            'is_external_link' => true,
            'link_ru' => 'https://google.com'
        ]);
        app()->setLocale('ru');
        $this->assertEquals('https://google.com', $menu->getUrl());
    }

    public function test_get_url_for_named_route()
    {
        // Assume 'contacts' route exists
        $menu = Menu::factory()->make([
            'is_external_link' => false,
            'link_kk' => 'search' // search route exists
        ]);
        app()->setLocale('kk');
        $this->assertStringContainsString('/search', $menu->getUrl());
    }

    public function test_get_url_for_page()
    {
        $page = Page::factory()->create(['slug' => 'test-page']);
        $menu = Menu::factory()->create();
        $menu->setRelation('page', $page);
        $menu->setRelation('product', null);

        $url = $menu->getUrl();
        $this->assertStringContainsString('/page/test-page', $url);
    }

    public function test_cache_is_invalidated_on_boot_events()
    {
        Cache::shouldReceive('supportsTags')->andReturn(false);
        Cache::shouldReceive('forget')->atLeast()->once();

        $menu = Menu::factory()->create();
        $menu->title_kk = 'Updated';
        $menu->save();
    }
}
