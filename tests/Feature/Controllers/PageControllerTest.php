<?php

namespace Tests\Feature\Controllers;

use App\Models\Page;
use App\Models\PageList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Tests\Traits\SeedsMandatoryWidgets;

class PageControllerTest extends TestCase
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

    public function test_page_index_returns_successful_response()
    {
        $page = Page::factory()->create([
            'slug' => 'test-page',
            'title_kk' => 'Test Page KK',
            'active' => true,
        ]);

        $response = $this->get("/kk/page/{$page->slug}");

        $response->assertStatus(200);
        $response->assertSee('Test Page KK');
    }

    public function test_page_index_returns_404_for_non_existent_page()
    {
        $response = $this->get('/kk/page/non-existent-slug');

        $response->assertStatus(404);
    }

    public function test_protected_page_redirects_to_login()
    {
        $page = Page::factory()->create([
            'slug' => 'protected-page',
            'is_protected' => true,
            'active' => true,
        ]);

        \Illuminate\Support\Facades\Auth::logout();

        $response = $this->get("/kk/page/{$page->slug}");

        $response->assertRedirect('/login');
    }

    public function test_protected_page_access_successful_when_authenticated()
    {
        $user = User::factory()->create();
        $this->be($user, 'ldap');

        $page = Page::factory()->create([
            'slug' => 'protected-page',
            'is_protected' => true,
            'active' => true,
        ]);

        $response = $this->get("/kk/page/{$page->slug}");

        $response->assertStatus(200);
    }

    public function test_page_list_item_with_date_returns_successful_response()
    {
        $page = Page::factory()->create();
        $pageList = PageList::factory()->create([
            'page_id' => $page->id,
            'title_kk' => 'List Item KK',
            'active' => true,
            'date' => now(),
        ]);

        $response = $this->get("/kk/list/{$pageList->id}");

        $response->assertStatus(200);
        $response->assertSee('List Item KK');
    }

    public function test_page_list_item_without_date_returns_successful_response()
    {
        $page = Page::factory()->create();
        $pageList = PageList::factory()->create([
            'page_id' => $page->id,
            'title_kk' => 'List Item No Date',
            'active' => true,
            'date' => null,
            'position' => 1,
        ]);

        $response = $this->get("/kk/list/{$pageList->id}");

        $response->assertStatus(200);
        $response->assertSee('List Item No Date');
    }

    public function test_page_list_item_next_prev()
    {
        $page = Page::factory()->create();
        $item1 = PageList::factory()->create(['page_id' => $page->id, 'position' => 1, 'date' => now()->subDay()]);
        $item2 = PageList::factory()->create(['page_id' => $page->id, 'position' => 2, 'date' => now()]);
        $item3 = PageList::factory()->create(['page_id' => $page->id, 'position' => 3, 'date' => now()->addDay()]);

        $response = $this->get("/kk/list/{$item2->id}");

        $response->assertStatus(200);
    }

    public function test_page_list_item_404_if_inactive()
    {
        $pageList = PageList::factory()->create(['active' => false]);
        $response = $this->get("/kk/list/{$pageList->id}");
        $response->assertStatus(404);
    }

    public function test_page_list_item_next_prev_without_date()
    {
        $page = Page::factory()->create();
        $item1 = PageList::factory()->create(['page_id' => $page->id, 'position' => 1, 'date' => null]);
        $item2 = PageList::factory()->create(['page_id' => $page->id, 'position' => 2, 'date' => null]);
        $item3 = PageList::factory()->create(['page_id' => $page->id, 'position' => 3, 'date' => null]);

        $response = $this->get("/kk/list/{$item2->id}");
        $response->assertStatus(200);
    }

    public function test_page_index_meta_title_with_parent()
    {
        $parent = \App\Models\Menu::factory()->create(['title_kk' => 'Parent Menu']);
        $menu = \App\Models\Menu::factory()->create(['parent_id' => $parent->id]);
        $page = Page::factory()->create(['slug' => 'p1', 'title_kk' => 'Child Page']);
        $menu->update(['page_id' => $page->id]);
        $page->update(['menu_id' => $menu->id]);

        $response = $this->get("/kk/page/{$page->slug}");
        $response->assertStatus(200);
        $response->assertSee('Parent Menu | Child Page');
    }
}
